<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\LicenseActivatedMail;
use App\Models\Site;
use App\Services\GamApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LicenseController extends Controller
{
    /**
     * POST /api/v1/activate
     *
     * Activate a license key for a specific WordPress site.
     */
    public function activate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'license_key' => ['required', 'string', 'size:32'],
            'site_url'    => ['required', 'url'],
            'wp_version'  => ['nullable', 'string'],
            'plugin_ver'  => ['nullable', 'string'],
        ]);

        $site = Site::byLicenseKey($validated['license_key'])->first();

        if (!$site) {
            return response()->json([
                'activated' => false,
                'message'   => 'License key not found.',
            ], 404);
        }

        // Verify the activation URL belongs to the same root domain the license was registered for
        $incomingBase   = self::extractBaseDomain($validated['site_url']);
        $registeredBase = self::extractBaseDomain($site->url);

        if ($incomingBase !== $registeredBase) {
            return response()->json([
                'activated' => false,
                'message'   => "This license key is registered to {$registeredBase}, not {$incomingBase}. Use the correct license key for this site.",
            ], 403);
        }

        $alreadyActivated = $site->activated;

        $site->update([
            'activated'     => true,
            'activated_url' => $validated['site_url'],
            'domain'        => $incomingBase,
            'activated_at'  => now(),
        ]);

        // Send activation email only on first activation, not on re-activations
        if (!$alreadyActivated) {
            $site->load('user');
            try {
                Mail::to($site->user->email)->send(new LicenseActivatedMail($site));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail failed: ' . $e->getMessage());
            }
        }

        return response()->json([
            'activated' => true,
            'message'   => 'License activated successfully.',
        ]);
    }

    /**
     * Extract the registrable base domain from a URL, stripping all subdomains.
     *
     * Handles compound country TLDs (co.uk, com.ng, net.ng, co.za, com.au…)
     * so subdomains like staging/www/news are always stripped correctly.
     *
     * Examples:
     *   https://staging.businessday.ng  → businessday.ng
     *   https://news.bbc.co.uk          → bbc.co.uk
     *   https://staging.punchng.com     → punchng.com
     *   https://www.bestbuy.com/foo     → bestbuy.com
     */
    public static function extractBaseDomain(string $url): string
    {
        // Ensure a scheme is present so parse_url extracts the host correctly
        if (!str_contains($url, '://')) {
            $url = 'https://' . $url;
        }

        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? $url);

        // Strip port (e.g. localhost:8080)
        $host = explode(':', $host)[0];

        $parts = explode('.', $host);
        $count = count($parts);

        if ($count <= 2) {
            return $host; // Already a root domain
        }

        // Second-level labels that form part of compound country TLDs:
        // e.g.  co.uk  com.ng  net.ng  org.ng  co.za  com.au
        $compoundSLDs = ['co', 'com', 'net', 'org', 'gov', 'edu', 'ac', 'sch', 'ltd', 'plc', 'ne', 'or', 'me'];

        $tld = $parts[$count - 1]; // e.g. "uk", "ng", "com"
        $sld = $parts[$count - 2]; // e.g. "co", "businessday"

        // Country-code TLD (2 chars) + known generic SLD → compound eTLD
        // Base domain is the last 3 parts: name.sld.tld
        if (strlen($tld) === 2 && in_array($sld, $compoundSLDs)) {
            return implode('.', array_slice($parts, -3));
        }

        // Everything else: base domain is name.tld (last 2 parts)
        return implode('.', array_slice($parts, -2));
    }

    /**
     * POST /api/v1/deactivate
     *
     * Free up a license seat.
     */
    public function deactivate(Request $request, GamApiService $gamService): JsonResponse
    {
        $key  = $request->input('license_key', '');
        $site = $key ? Site::byLicenseKey($key)->with('gamToken')->first() : null;

        if ($site) {
            // Revoke GAM tokens - losing the license means losing the GAM connection.
            $gamService->revokeTokens($site);

            $site->update([
                'activated'     => false,
                'activated_url' => '',
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * GET /api/v1/verify?license_key=XXX
     *
     * Check if a license is valid and activated.
     */
    public function verify(Request $request): JsonResponse
    {
        $key  = $request->query('license_key', '');
        $site = Site::byLicenseKey($key)->activated()->first();

        if (!$site) {
            return response()->json([
                'valid'    => false,
                'site_url' => '',
            ]);
        }

        if ($site->isSuspended()) {
            return response()->json([
                'valid'   => false,
                'message' => 'Account suspended.',
            ], 403);
        }

        return response()->json([
            'valid'    => true,
            'site_url' => $site->activated_url ?? '',
        ]);
    }
}
