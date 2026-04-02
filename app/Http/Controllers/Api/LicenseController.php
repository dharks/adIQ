<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Services\GamApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        $site->update([
            'activated'     => true,
            'activated_url' => $validated['site_url'],
            'domain'        => self::extractBaseDomain($validated['site_url']),
            'activated_at'  => now(),
        ]);

        return response()->json([
            'activated' => true,
            'message'   => 'License activated successfully.',
        ]);
    }

    /**
     * Extract the base domain from a URL, stripping www. and the scheme.
     * e.g. "https://staging.bestbuy.com/foo" → "staging.bestbuy.com"
     * and  "https://www.bestbuy.com"          → "bestbuy.com"
     */
    public static function extractBaseDomain(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST) ?? $url;
        $host = preg_replace('/^www\./i', '', strtolower($host));
        return $host;
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
            // Revoke GAM tokens — losing the license means losing the GAM connection.
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
