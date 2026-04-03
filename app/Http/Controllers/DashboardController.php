<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\LicenseController;
use App\Models\Site;
use App\Models\SiteSubdomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sites = Auth::user()->sites()->latest()->get();

        return view('dashboard', compact('sites'));
    }

    public function addSite(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'url', 'max:500'],
        ]);

        $site = Auth::user()->sites()->create([
            'url'    => $validated['url'],
            'domain' => LicenseController::extractBaseDomain($validated['url']),
        ]);

        return redirect()->route('dashboard')
            ->with('flash', "Site added! Your license key: {$site->license_key}");
    }

    public function deleteSite(Request $request, Site $site)
    {
        if ($site->user_id !== Auth::id()) abort(403);

        $site->delete();

        return redirect()->route('dashboard')->with('flash', 'Site removed.');
    }

    public function showSite(Site $site)
    {
        if ($site->user_id !== Auth::id()) abort(403);

        $site->load('allowedSubdomains');

        return view('site-detail', [
            'site'       => $site,
            'subdomains' => $site->allowedSubdomains,
            'remaining'  => max(0, 5 - $site->allowedSubdomains->count()),
        ]);
    }

    public function addSubdomain(Request $request, Site $site)
    {
        if ($site->user_id !== Auth::id()) abort(403);

        $request->validate([
            'subdomain' => ['required', 'string', 'max:63', 'regex:/^[a-z0-9]([a-z0-9\-]*[a-z0-9])?$/i'],
        ]);

        if ($site->allowedSubdomains()->count() >= 5) {
            return back()->withErrors(['subdomain' => 'Maximum of 5 subdomains allowed.']);
        }

        $prefix = strtolower($request->subdomain);

        if ($site->allowedSubdomains()->where('subdomain', $prefix)->exists()) {
            return back()->withErrors(['subdomain' => '"' . $prefix . '" is already registered.']);
        }

        $site->allowedSubdomains()->create(['subdomain' => $prefix]);

        return redirect()->route('sites.show', $site)->with('flash', '"' . $prefix . '" added.');
    }

    public function deleteSubdomain(Request $request, Site $site, string $subdomain)
    {
        if ($site->user_id !== Auth::id()) abort(403);

        $site->allowedSubdomains()->where('subdomain', strtolower($subdomain))->delete();

        return redirect()->route('sites.show', $site)->with('flash', '"' . $subdomain . '" removed.');
    }
}
