<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\GamConnectedMail;
use App\Models\GamToken;
use App\Models\Site;
use App\Services\GamApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GamOAuthController extends Controller
{
    public function __construct(
        private GamApiService $gamService
    ) {}

    /**
     * GET /oauth/gam/init
     *
     * Start the OAuth flow. Called by the WordPress plugin.
     * Stores context in session, then redirects to Google.
     */
    public function init(Request $request)
    {
        $licenseKey  = $request->query('license_key', '');
        $redirectUri = $request->query('redirect_uri', '');
        $state       = $request->query('state', '');

        if (empty($licenseKey) || empty($redirectUri)) {
            return response()->json(['message' => 'Missing parameters.'], 400);
        }

        // Verify license exists
        $site = Site::byLicenseKey($licenseKey)->first();
        if (!$site) {
            return response()->json(['message' => 'Invalid license key.'], 404);
        }

        // Store callback context
        session([
            'gam_oauth' => [
                'license_key'  => $licenseKey,
                'redirect_uri' => $redirectUri,
                'state'        => $state,
                'site_id'      => $site->id,
            ],
        ]);

        $authUrl = $this->gamService->getAuthUrl($licenseKey);

        return redirect($authUrl);
    }

    /**
     * GET /oauth/gam/callback
     *
     * Google redirects here after the publisher authorizes.
     * Exchange the code for tokens, store them, redirect back to WP.
     */
    public function callback(Request $request)
    {
        $code  = $request->query('code', '');
        $oauth = session('gam_oauth');

        if (empty($code) || empty($oauth['site_id'])) {
            return response('OAuth failed. Please try again from your WordPress dashboard.', 400);
        }

        $site = Site::find($oauth['site_id']);
        if (!$site) {
            return response('Site not found.', 404);
        }

        // Exchange authorization code for tokens
        $tokens = $this->gamService->exchangeCode($code);

        if (!$tokens || empty($tokens['access_token'])) {
            return response('Failed to get access token from Google. Please try again.', 500);
        }

        // Get the publisher's email
        $email = $this->gamService->getUserEmail($tokens['access_token']);

        // Store (or replace) tokens
        GamToken::updateOrCreate(
            ['site_id' => $site->id],
            [
                'access_token'  => $tokens['access_token'],
                'refresh_token' => $tokens['refresh_token'] ?? '',
                'expires_at'    => now()->addSeconds($tokens['expires_in'] ?? 3600),
                'email'         => $email,
            ]
        );

        // Mark the site as GAM-connected
        $site->update([
            'gam_connected' => true,
            'gam_email'     => $email,
        ]);

        // Fetch available GAM networks so the user can choose which one to use
        $networks = $this->gamService->fetchNetworks($tokens['access_token']);

        // Store networks in session and show selection page
        session(['gam_networks' => $networks]);

        return view('oauth.select-network', [
            'networks'    => $networks,
            'redirectUri' => $oauth['redirect_uri'],
            'email'       => $email,
        ]);
    }

    /**
     * POST /oauth/gam/select-network
     *
     * Publisher chooses which GAM network to use.
     * Redirects back to WordPress with network_id included.
     */
    public function selectNetwork(Request $request)
    {
        $networkId   = $request->input('network_id', '');
        $networkName = $request->input('network_name', '');
        $redirectUri = $request->input('redirect_uri', '');

        if (empty($networkId) || empty($redirectUri)) {
            return back()->withErrors(['Please select a network.']);
        }

        // Persist the chosen network ID on the site record
        $oauth = session('gam_oauth');
        if (!empty($oauth['site_id'])) {
            $site = Site::find($oauth['site_id']);
            if ($site) {
                $site->update([
                    'gam_network_id'   => $networkId,
                    'gam_network_name' => $networkName,
                ]);
                $site->load('user');
                Mail::to($site->user->email)->send(new GamConnectedMail($site));
            }
        }

        session()->forget(['gam_oauth', 'gam_networks']);

        $separator = str_contains($redirectUri, '?') ? '&' : '?';

        return redirect("{$redirectUri}{$separator}gam_connected=1&network_id=" . urlencode($networkId) . '&network_name=' . urlencode($networkName));
    }
}
