<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubdomainController extends Controller
{
    private const MAX_SUBDOMAINS = 5;

    /**
     * GET /api/v1/subdomains
     *
     * List registered subdomain prefixes for this license.
     */
    public function index(Request $request): JsonResponse
    {
        $site       = $request->input('_adiq_site');
        $subdomains = $site->allowedSubdomains()->get(['id', 'subdomain', 'created_at']);

        return response()->json([
            'domain'     => $site->domain,
            'subdomains' => $subdomains,
            'limit'      => self::MAX_SUBDOMAINS,
            'remaining'  => max(0, self::MAX_SUBDOMAINS - $subdomains->count()),
        ]);
    }

    /**
     * POST /api/v1/subdomains
     *
     * Register a new subdomain prefix (e.g. "staging").
     * Rejects if the limit of 5 is already reached.
     */
    public function store(Request $request): JsonResponse
    {
        $site = $request->input('_adiq_site');

        if ($site->allowedSubdomains()->count() >= self::MAX_SUBDOMAINS) {
            return response()->json([
                'message' => 'You have reached the maximum of ' . self::MAX_SUBDOMAINS . ' allowed subdomains.',
            ], 422);
        }

        $validated = $request->validate([
            // Only the prefix part - letters, numbers, hyphens, no dots
            'subdomain' => [
                'required',
                'string',
                'max:63',
                'regex:/^[a-z0-9]([a-z0-9\-]*[a-z0-9])?$/i',
            ],
        ]);

        $prefix = strtolower($validated['subdomain']);

        if ($site->allowedSubdomains()->where('subdomain', $prefix)->exists()) {
            return response()->json([
                'message' => '"' . $prefix . '" is already registered.',
            ], 422);
        }

        $record = $site->allowedSubdomains()->create(['subdomain' => $prefix]);

        return response()->json([
            'subdomain' => $record->only(['id', 'subdomain', 'created_at']),
            'remaining' => max(0, self::MAX_SUBDOMAINS - $site->allowedSubdomains()->count()),
        ], 201);
    }

    /**
     * DELETE /api/v1/subdomains/{subdomain}
     *
     * Remove a registered subdomain prefix by its name.
     */
    public function destroy(Request $request, string $subdomain): JsonResponse
    {
        $site    = $request->input('_adiq_site');
        $deleted = $site->allowedSubdomains()->where('subdomain', strtolower($subdomain))->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Subdomain not found.'], 404);
        }

        return response()->json([
            'success'   => true,
            'remaining' => max(0, self::MAX_SUBDOMAINS - $site->allowedSubdomains()->count()),
        ]);
    }
}
