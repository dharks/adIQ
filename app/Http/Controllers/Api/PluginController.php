<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     */
    public function version(Request $request): JsonResponse
    {
        return response()->json([
            'name'         => 'AdIQ – Smart Ad Manager',
            'slug'         => 'adiq',
            'version'      => config('plugin.version'),
            'author'       => 'AdIQ',
            'homepage'     => 'https://adiq.io',
            'requires'     => config('plugin.requires_wp'),
            'tested'       => config('plugin.tested_wp'),
            'requires_php' => config('plugin.requires_php'),
            'last_updated' => config('plugin.last_updated'),
            'download_url' => url('/api/v1/plugin/download'),
            'sections'     => [
                'description' => 'Connect Google Ad Manager and AdSense, create ad units, and display them anywhere with shortcodes. Includes lazy loading, device targeting, CLS prevention, file-based caching, and third-party ad support.',
                'changelog'   => config('plugin.changelog'),
            ],
        ]);
    }

    /**
     * GET /api/v1/plugin/download?license_key=XXX
     *
     * Requires a valid, activated, non-suspended license key.
     * Streams the plugin zip file directly to the client.
     */
    public function download(Request $request): BinaryFileResponse|JsonResponse
    {
        $key  = strtolower(trim($request->query('license_key', '')));
        $site = Site::where('license_key', $key)
            ->where('activated', true)
            ->first();

        if (!$site || $site->suspended_at !== null) {
            return response()->json([
                'message' => 'Invalid or inactive license key.',
            ], 403);
        }

        $path = storage_path('app/' . config('plugin.zip_path'));

        if (!file_exists($path)) {
            return response()->json([
                'message' => 'Plugin file not available. Please contact support.',
            ], 404);
        }

        return response()->download($path, 'adiq.zip', [
            'Content-Type' => 'application/zip',
        ]);
    }
}
