<?php

namespace App\Services;

use App\Models\GamToken;
use App\Models\Site;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GamApiService
{
    /**
     * Build the Google OAuth2 authorization URL.
     */
    public function getAuthUrl(string $state): string
    {
        $params = http_build_query([
            'client_id'     => config('adiq.gam_client_id'),
            'redirect_uri'  => config('adiq.gam_redirect_uri'),
            'response_type' => 'code',
            'scope'         => config('adiq.gam_scopes'),
            'access_type'   => 'offline',
            'prompt'        => 'consent',
            'state'         => $state,
        ]);

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . $params;
    }

    /**
     * Exchange an authorization code for access & refresh tokens.
     */
    public function exchangeCode(string $code): ?array
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => config('adiq.gam_client_id'),
            'client_secret' => config('adiq.gam_client_secret'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => config('adiq.gam_redirect_uri'),
        ]);

        if ($response->failed()) {
            Log::error('GAM token exchange failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    /**
     * Refresh an expired access token.
     */
    public function refreshAccessToken(string $refreshToken): ?array
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => config('adiq.gam_client_id'),
            'client_secret' => config('adiq.gam_client_secret'),
            'refresh_token' => $refreshToken,
            'grant_type'    => 'refresh_token',
        ]);

        if ($response->failed()) {
            Log::error('GAM token refresh failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    /**
     * Get the authenticated user's email from Google.
     */
    public function getUserEmail(string $accessToken): string
    {
        $response = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v2/userinfo');

        return $response->json('email', '');
    }

    /**
     * Ensure we have a valid (non-expired) access token.
     * Refreshes automatically if needed.
     */
    public function getValidAccessToken(GamToken $token): ?string
    {
        if (!$token->isExpired()) {
            return $token->access_token;
        }

        if (empty($token->refresh_token)) {
            return null;
        }

        $refreshed = $this->refreshAccessToken($token->refresh_token);

        if (!$refreshed || empty($refreshed['access_token'])) {
            return null;
        }

        $token->update([
            'access_token' => $refreshed['access_token'],
            'expires_at'   => now()->addSeconds($refreshed['expires_in'] ?? 3600),
        ]);

        return $refreshed['access_token'];
    }

    /**
     * Fetch all GAM networks accessible to the authenticated user.
     */
    public function fetchNetworks(string $accessToken): array
    {
        $response = Http::withToken($accessToken)
            ->timeout(15)
            ->get(config('adiq.gam_api_base') . '/networks');

        if ($response->failed()) {
            Log::error('GAM fetchNetworks failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return [];
        }

        return $response->json('networks', []);
    }

    /**
     * Fetch all ad units from Google Ad Manager (all levels, all pages).
     */
    public function fetchAdUnits(string $accessToken, string $networkId): array
    {
        $baseUrl   = config('adiq.gam_api_base') . "/networks/{$networkId}/adUnits";
        $units     = [];
        $pageToken = null;

        do {
            $params = ['pageSize' => 200];
            if ($pageToken) {
                $params['pageToken'] = $pageToken;
            }

            $response = Http::withToken($accessToken)
                ->timeout(30)
                ->get($baseUrl, $params);

            if ($response->failed()) {
                Log::error('GAM fetchAdUnits failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                break;
            }

            foreach ($response->json('adUnits', []) as $unit) {
                $sizes = [];
                foreach ($unit['adUnitSizes'] ?? [] as $s) {
                    if (isset($s['size']['width'], $s['size']['height'])) {
                        $sizes[] = $s['size']['width'] . 'x' . $s['size']['height'];
                    }
                }

                $units[] = [
                    'id'          => $unit['name'] ?? '',
                    'parentId'    => $unit['parentAdUnit'] ?? '',
                    'name'        => $unit['adUnitCode'] ?? '',
                    'displayName' => $unit['displayName'] ?? '',
                    'adUnitPath'  => "/{$networkId}/" . ($unit['adUnitCode'] ?? ''),
                    'sizes'       => implode(', ', array_unique($sizes)),
                    'status'      => $unit['status'] ?? 'ACTIVE',
                ];
            }

            $pageToken = $response->json('nextPageToken');

        } while (!empty($pageToken));

        $this->assignFullPaths($units);

        return $units;
    }

    /**
     * Assign a hierarchical fullPath to every unit in a flat list by walking
     * each unit's parent chain — mirrors the JS buildTree/assignPaths logic.
     *
     * Root container units (ca-pub-XXXX) are excluded from the path, exactly
     * as the JS isRootContainer unwrap does.
     */
    private function assignFullPaths(array &$units): void
    {
        $idToCode   = [];
        $idToParent = [];
        foreach ($units as $u) {
            $idToCode[$u['id']]   = $u['name'];
            $idToParent[$u['id']] = $u['parentId'];
        }

        foreach ($units as &$u) {
            $path      = [];
            $currentId = $u['id'];
            $visited   = [];

            while ($currentId && !isset($visited[$currentId])) {
                $visited[$currentId] = true;
                $code = $idToCode[$currentId] ?? '';

                if (!empty($code) && !preg_match('/^ca-pub-\d+:?$/i', $code)) {
                    array_unshift($path, $code);
                }

                $currentId = $idToParent[$currentId] ?? null;
            }

            $u['fullPath'] = implode('/', $path);
        }
        unset($u);
    }

    /**
     * Fetch a single ad unit by its numeric ID and reconstruct the full
     * hierarchical path by walking up the parent chain.
     *
     * The returned 'name' matches the fullPath that assignPaths() builds
     * in the JS tree (e.g. "Sports/Banner", not just "Banner").
     */
    public function fetchAdUnit(string $accessToken, string $networkId, string $unitId): ?array
    {
        $chain       = [];   // codes collected root → target
        $sizes       = [];
        $status      = 'ACTIVE';
        $displayName = '';
        $currentId   = $unitId;

        // Walk up the parent chain (cap at 8 levels to prevent runaway)
        for ($depth = 0; $depth < 8; $depth++) {
            $url      = config('adiq.gam_api_base') . "/networks/{$networkId}/adUnits/{$currentId}";
            $response = Http::withToken($accessToken)->timeout(10)->get($url);

            if ($response->failed()) {
                // If the very first request fails the unit doesn't exist
                if ($depth === 0) return null;
                break;
            }

            $unit = $response->json();
            $code = $unit['adUnitCode'] ?? '';

            // Collect sizes and label from the target unit only
            if ($depth === 0) {
                $displayName = $unit['displayName'] ?? $code;
                $status      = $unit['status'] ?? 'ACTIVE';
                foreach ($unit['adUnitSizes'] ?? [] as $s) {
                    if (isset($s['size']['width'], $s['size']['height'])) {
                        $sizes[] = $s['size']['width'] . 'x' . $s['size']['height'];
                    }
                }
            }

            // Root unit has no parentAdUnit — stop here without adding its code
            $parent = $unit['parentAdUnit'] ?? '';
            if (empty($parent)) break;

            // Not the root — include this unit's code in the path
            if (!empty($code)) {
                array_unshift($chain, $code);
            }

            // Extract the parent's numeric ID from "networks/{n}/adUnits/{id}"
            $parts     = explode('/', $parent);
            $currentId = end($parts);
        }

        if (empty($chain)) return null;

        // Strip any leading AdSense/container codes (e.g. ca-pub-XXXX) from the
        // front of the chain — mirrors the JS buildTree isRootContainer unwrap.
        while (!empty($chain) && preg_match('/^ca-pub-\d+:?$/i', $chain[0])) {
            array_shift($chain);
        }

        if (empty($chain)) return null;

        $fullPath = implode('/', $chain);

        return [
            'id'          => "networks/{$networkId}/adUnits/{$unitId}",
            'name'        => $fullPath,
            'displayName' => $displayName,
            'adUnitPath'  => "/{$networkId}/{$fullPath}",
            'sizes'       => implode(', ', array_unique($sizes)),
            'status'      => $status,
        ];
    }

    /**
     * Set up AdIQ's standard key-value pairs in GAM.
     *
     * Keys created (if they don't exist):
     *   - page_type  (PREDEFINED, values: home / article / section)
     *   - page_title (FREEFORM)
     *   - category   (FREEFORM)
     *
     * Returns a summary array of what was created vs already existed.
     */
    public function setupKeyValues(string $accessToken, string $networkId): array
    {
        $schema = [
            'adiq_page_type'  => ['type' => 'PREDEFINED', 'values' => ['home', 'article', 'section']],
            'adiq_page_title' => ['type' => 'FREEFORM',   'values' => []],
            'adiq_category'   => ['type' => 'FREEFORM',   'values' => []],
        ];

        $existingKeys = $this->fetchCustomTargetingKeys($accessToken, $networkId);
        $keysByName   = [];
        foreach ($existingKeys as $k) {
            $keysByName[$k['keyName']] = $k;
        }

        $report = [];

        foreach ($schema as $keyName => $def) {
            if (isset($keysByName[$keyName])) {
                $key    = $keysByName[$keyName];
                $status = 'already_exists';
            } else {
                $key    = $this->createCustomTargetingKey($accessToken, $networkId, $keyName, $def['type']);
                $status = $key ? 'created' : 'error';
            }

            $valuesCreated  = [];
            $valuesExisting = [];

            if ($key && !empty($def['values'])) {
                $keyId          = $this->extractResourceId($key['name']);
                $existingValues = $this->fetchCustomTargetingValues($accessToken, $networkId, $keyId);
                $existingNames  = array_column($existingValues, 'valueName');

                foreach ($def['values'] as $valueName) {
                    if (in_array($valueName, $existingNames, true)) {
                        $valuesExisting[] = $valueName;
                    } else {
                        $created = $this->createCustomTargetingValue($accessToken, $networkId, $keyId, $valueName);
                        if ($created) {
                            $valuesCreated[] = $valueName;
                        }
                    }
                }
            }

            $report[$keyName] = [
                'status'          => $status,
                'values_created'  => $valuesCreated,
                'values_existing' => $valuesExisting,
            ];
        }

        return $report;
    }

    /**
     * Fetch all custom targeting keys for a network.
     */
    public function fetchCustomTargetingKeys(string $accessToken, string $networkId): array
    {
        $url    = config('adiq.gam_api_base') . "/networks/{$networkId}/customTargetingKeys";
        $keys   = [];
        $pageToken = null;

        do {
            $params = ['pageSize' => 100];
            if ($pageToken) $params['pageToken'] = $pageToken;

            $response = Http::withToken($accessToken)->timeout(15)->get($url, $params);

            if ($response->failed()) {
                Log::error('GAM fetchCustomTargetingKeys failed', ['status' => $response->status(), 'body' => $response->body()]);
                break;
            }

            foreach ($response->json('customTargetingKeys', []) as $key) {
                $keys[] = [
                    'name'    => $key['name']    ?? '',
                    'keyName' => $key['keyName'] ?? '',
                    'type'    => $key['type']    ?? 'FREEFORM',
                    'status'  => $key['status']  ?? 'ACTIVE',
                ];
            }

            $pageToken = $response->json('nextPageToken');
        } while (!empty($pageToken));

        return $keys;
    }

    /**
     * Create a custom targeting key.
     */
    public function createCustomTargetingKey(string $accessToken, string $networkId, string $keyName, string $type): ?array
    {
        $url      = config('adiq.gam_api_base') . "/networks/{$networkId}/customTargetingKeys";
        $response = Http::withToken($accessToken)->timeout(15)->post($url, [
            'displayName' => $keyName,
            'keyName'     => $keyName,
            'type'        => $type,
        ]);

        if ($response->failed()) {
            Log::error('GAM createCustomTargetingKey failed', ['key' => $keyName, 'status' => $response->status(), 'body' => $response->body()]);
            return null;
        }

        $body = $response->json();
        return [
            'name'    => $body['name']    ?? '',
            'keyName' => $body['keyName'] ?? $keyName,
            'type'    => $body['type']    ?? $type,
        ];
    }

    /**
     * Fetch all values for a custom targeting key.
     */
    public function fetchCustomTargetingValues(string $accessToken, string $networkId, string $keyId): array
    {
        $url    = config('adiq.gam_api_base') . "/networks/{$networkId}/customTargetingKeys/{$keyId}/customTargetingValues";
        $values = [];
        $pageToken = null;

        do {
            $params = ['pageSize' => 100];
            if ($pageToken) $params['pageToken'] = $pageToken;

            $response = Http::withToken($accessToken)->timeout(15)->get($url, $params);
            if ($response->failed()) break;

            foreach ($response->json('customTargetingValues', []) as $val) {
                $values[] = [
                    'name'      => $val['name']      ?? '',
                    'valueName' => $val['valueName'] ?? '',
                ];
            }

            $pageToken = $response->json('nextPageToken');
        } while (!empty($pageToken));

        return $values;
    }

    /**
     * Create a custom targeting value under a key.
     */
    public function createCustomTargetingValue(string $accessToken, string $networkId, string $keyId, string $valueName): ?array
    {
        $url      = config('adiq.gam_api_base') . "/networks/{$networkId}/customTargetingKeys/{$keyId}/customTargetingValues";
        $response = Http::withToken($accessToken)->timeout(15)->post($url, [
            'displayName' => $valueName,
            'valueName'   => $valueName,
        ]);

        if ($response->failed()) {
            Log::error('GAM createCustomTargetingValue failed', ['keyId' => $keyId, 'value' => $valueName, 'status' => $response->status()]);
            return null;
        }

        $body = $response->json();
        return ['name' => $body['name'] ?? '', 'valueName' => $body['valueName'] ?? $valueName];
    }

    /**
     * Extract the numeric ID from a GAM resource name.
     * e.g. "networks/1234/customTargetingKeys/5678" → "5678"
     */
    private function extractResourceId(string $resourceName): string
    {
        $parts = explode('/', $resourceName);
        return end($parts);
    }

    /**
     * Revoke stored tokens for a site.
     */
    public function revokeTokens(Site $site): void
    {
        $site->gamToken?->delete();
        $site->update([
            'gam_connected'    => false,
            'gam_email'        => '',
            'gam_network_id'   => '',
            'gam_network_name' => '',
        ]);
    }
}
