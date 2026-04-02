<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Services\GamApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GamController extends Controller
{
    public function __construct(
        private GamApiService $gamService
    ) {}

    /**
     * GET /api/v1/gam/adunits?license_key=XXX
     *
     * Fetch ad units from GAM using the stored OAuth token.
     * The network ID is read from the server-side Site record — the plugin
     * must never supply it, so it cannot be spoofed by a modified plugin.
     */
    public function adUnits(Request $request): JsonResponse
    {
        $key  = $request->query('license_key', '');
        $site = Site::byLicenseKey($key)->activated()->with('gamToken')->first();

        if (!$site) {
            return response()->json(['message' => 'Invalid or inactive license.'], 403);
        }

        if (empty($site->gam_network_id)) {
            return response()->json(['message' => 'GAM network not configured. Complete the OAuth connection first.'], 401);
        }

        if (!$site->gamToken) {
            return response()->json(['message' => 'GAM not connected. Connect via the plugin first.'], 401);
        }

        $accessToken = $this->gamService->getValidAccessToken($site->gamToken);

        if (!$accessToken) {
            return response()->json(['message' => 'GAM token expired. Please reconnect.'], 401);
        }

        $units = $this->gamService->fetchAdUnits($accessToken, $site->gam_network_id);

        return response()->json(['units' => $units]);
    }

    /**
     * GET /api/v1/gam/adunit?license_key=XXX&unit_id=XXX
     *
     * Fetch a single ad unit by its numeric GAM ID.
     * Walks the parent chain to return the full hierarchical path.
     * The network ID is read server-side — never trusted from the request.
     */
    public function adUnit(Request $request): JsonResponse
    {
        $key    = $request->query('license_key', '');
        $unitId = trim($request->query('unit_id', ''));

        if (empty($unitId)) {
            return response()->json(['message' => 'unit_id is required.'], 422);
        }

        $site = Site::byLicenseKey($key)->activated()->with('gamToken')->first();

        if (!$site) {
            return response()->json(['message' => 'Invalid or inactive license.'], 403);
        }

        if (empty($site->gam_network_id)) {
            return response()->json(['message' => 'GAM network not configured. Complete the OAuth connection first.'], 401);
        }

        if (!$site->gamToken) {
            return response()->json(['message' => 'GAM not connected. Connect via the plugin first.'], 401);
        }

        $accessToken = $this->gamService->getValidAccessToken($site->gamToken);

        if (!$accessToken) {
            return response()->json(['message' => 'GAM token expired. Please reconnect.'], 401);
        }

        $unit = $this->gamService->fetchAdUnit($accessToken, $site->gam_network_id, $unitId);

        if (!$unit) {
            return response()->json(['message' => 'Ad unit not found. Check the ID and try again.'], 404);
        }

        return response()->json(['unit' => $unit]);
    }

    /**
     * POST /api/v1/gam/setup-keyvalues
     *
     * Create AdIQ's standard GAM key-value pairs if they don't exist.
     */
    public function setupKeyValues(Request $request): JsonResponse
    {
        $site = $request->input('_adiq_site');

        if (!$site->gamToken) {
            return response()->json(['message' => 'GAM not connected.'], 401);
        }

        $accessToken = $this->gamService->getValidAccessToken($site->gamToken);
        if (!$accessToken) {
            return response()->json(['message' => 'GAM token expired. Please reconnect.'], 401);
        }

        $report = $this->gamService->setupKeyValues($accessToken, $site->gam_network_id);

        return response()->json(['success' => true, 'report' => $report]);
    }

    /**
     * POST /api/v1/gam/revoke
     *
     * Revoke GAM tokens for a site.
     */
    public function revoke(Request $request): JsonResponse
    {
        $key  = $request->input('license_key', '');
        $site = Site::byLicenseKey($key)->first();

        if ($site) {
            $this->gamService->revokeTokens($site);
        }

        return response()->json(['success' => true]);
    }
}
