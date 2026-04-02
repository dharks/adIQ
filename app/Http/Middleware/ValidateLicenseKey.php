<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\LicenseController;
use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateLicenseKey
{
    /**
     * Validate every protected API request in three layers:
     *
     *  1. License key — must exist and be activated.
     *  2. HMAC signature — proves site_url has not been spoofed.
     *     signature = HMAC-SHA256( site_url . "\n" . timestamp, license_key )
     *     timestamp must be within ±5 minutes (prevents replay attacks).
     *  3. Domain whitelist — site_url's domain must be the license root
     *     domain or a registered subdomain prefix (max 5).
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ── Layer 1: license key format & activation ──────────────
        $key = $request->input('license_key', $request->query('license_key', ''));

        if (empty($key) || strlen($key) !== 32 || !ctype_alnum($key)) {
            return response()->json(['message' => 'Missing or malformed license key.'], 401);
        }

        $site = Site::byLicenseKey($key)->activated()->with('allowedSubdomains')->first();

        if (!$site) {
            return response()->json(['message' => 'Invalid or inactive license key.'], 403);
        }

        if ($site->isSuspended()) {
            return response()->json(['message' => 'Account suspended. Please contact support.'], 403);
        }

        // ── Layer 2: HMAC signature ───────────────────────────────
        $siteUrl   = $request->input('site_url',  $request->query('site_url',  ''));
        $timestamp = (int) ($request->input('timestamp', $request->query('timestamp', 0)));
        $signature = $request->input('signature', $request->query('signature', ''));

        if (empty($siteUrl) || empty($timestamp) || empty($signature)) {
            return response()->json(['message' => 'Request must be signed (site_url, timestamp, signature required).'], 401);
        }

        // Timestamp must be within ±5 minutes to prevent replay attacks
        if (abs(time() - $timestamp) > 300) {
            return response()->json(['message' => 'Request expired. Ensure your server clock is accurate.'], 401);
        }

        // Use $key (exact string from request) not $site->license_key — MySQL's
        // case-insensitive lookup can match a different-cased DB value, which
        // would produce a different HMAC than what the plugin computed.
        $expected = hash_hmac('sha256', $siteUrl . "\n" . $timestamp, $key);

        // Constant-time comparison prevents timing attacks
        if (!hash_equals($expected, $signature)) {
            return response()->json(['message' => 'Invalid request signature.'], 401);
        }

        // ── Layer 3: domain whitelist ─────────────────────────────
        // At this point site_url is cryptographically verified — we trust it.
        if (!empty($site->domain)) {
            $requestDomain = LicenseController::extractBaseDomain($siteUrl);

            if (!$this->domainAllowed($requestDomain, $site)) {
                return response()->json([
                    'message' => 'This domain is not authorised for this license. '
                        . 'Add it as an allowed subdomain in your AdIQ account.',
                ], 403);
            }
        }

        $request->merge(['_adiq_site' => $site]);

        return $next($request);
    }

    /**
     * Returns true if $requestDomain is the license root domain
     * or a registered single-level subdomain of it.
     */
    private function domainAllowed(string $requestDomain, Site $site): bool
    {
        $root    = strtolower($site->domain);
        $request = strtolower($requestDomain);

        if ($request === $root) {
            return true;
        }

        if (!str_ends_with($request, '.' . $root)) {
            return false;
        }

        $prefix = substr($request, 0, strlen($request) - strlen($root) - 1);

        // Reject nested subdomains (sub.staging.bestbuy.com)
        if (str_contains($prefix, '.')) {
            return false;
        }

        return $site->allowedSubdomains->contains('subdomain', $prefix);
    }
}
