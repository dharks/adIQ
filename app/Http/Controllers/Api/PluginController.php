<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PluginRelease;
use App\Models\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PluginController extends Controller
{
    /**
     * GET /api/v1/plugin/version
     *
     * Public endpoint - returns plugin metadata for WordPress update checks.
     * Reads from the latest active release in the DB; falls back to config.
     */
    public function version(Request $request): JsonResponse
    {
        $release = PluginRelease::latest();

        return response()->json([
            'name'         => 'adIQ - Smart Ad Manager',
            'slug'         => 'adiq',
            'version'      => $release?->version      ?? config('plugin.version'),
            'author'       => 'adIQ by Percivo',
            'homepage'     => config('app.url'),
            'requires'     => $release?->requires_wp  ?? config('plugin.requires_wp'),
            'tested'       => $release?->tested_wp    ?? config('plugin.tested_wp'),
            'requires_php' => $release?->requires_php ?? config('plugin.requires_php'),
            'last_updated' => $release?->updated_at?->toDateString() ?? config('plugin.last_updated'),
            'download_url' => url('/api/v1/plugin/download'),
            'sections'     => [
                'description' => 'Connect Google Ad Manager and AdSense, create ad units, and display them anywhere with shortcodes. Includes lazy loading, device targeting, CLS prevention, file-based caching, and third-party ad support.',
                'changelog'   => $release?->changelog ?? config('plugin.changelog'),
            ],
        ]);
    }

    /**
     * GET /api/v1/plugin/download?license_key=XXX
     *
     * Requires a valid, activated, non-suspended license key.
     * Streams the latest plugin zip to the client.
     */
    public function download(Request $request): BinaryFileResponse|JsonResponse
    {
        $key  = strtolower(trim($request->query('license_key', '')));
        $site = Site::where('license_key', $key)
                    ->where('activated', true)
                    ->first();

        if (!$site || $site->suspended_at !== null) {
            return response()->json(['message' => 'Invalid or inactive license key.'], 403);
        }

        // Use the latest release's zip path, falling back to config
        $release  = PluginRelease::latest();
        $zipPath  = $release?->zip_path ?? config('plugin.zip_path');
        $fullPath = storage_path('app/' . $zipPath);

        if (!$fullPath || !file_exists($fullPath)) {
            return response()->json(['message' => 'Plugin file not available. Please contact support.'], 404);
        }

        return response()->download($fullPath, 'adiq.zip', [
            'Content-Type' => 'application/zip',
        ]);
    }
}
