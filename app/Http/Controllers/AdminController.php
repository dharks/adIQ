<?php

namespace App\Http\Controllers;

use App\Mail\AccountReinstatedMail;
use App\Mail\AccountSuspendedMail;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * GET /admin
     * List all sites across all users, with optional search.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search', '');

        $query = User::where('is_admin', false)
            ->with(['sites'])
            ->orderBy('created_at', 'desc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhereHas('sites', function ($sq) use ($search) {
                      $sq->where('url', 'like', '%' . $search . '%')
                         ->orWhere('domain', 'like', '%' . $search . '%')
                         ->orWhere('license_key', 'like', '%' . $search . '%');
                  });
            });
        }

        $users          = $query->paginate(15)->withQueryString();
        $totalUsers     = User::where('is_admin', false)->count();
        $activeSites    = Site::active()->count();
        $suspendedSites = Site::suspended()->count();

        return view('admin.index', compact('users', 'search', 'totalUsers', 'activeSites', 'suspendedSites'));
    }

    /**
     * GET /admin/users/{user}
     * Show full profile for any registered user, with or without sites.
     */
    public function showUser(User $user): View
    {
        $user->load(['sites.allowedSubdomains', 'sites.gamToken']);
        return view('admin.user', compact('user'));
    }

    /**
     * DELETE /admin/users/{user}
     * Delete a user and all their associated data.
     */
    public function destroyUser(User $user): RedirectResponse
    {
        $name = $user->email;
        // Clean up all related site data first
        foreach ($user->sites as $site) {
            $site->gamToken()?->delete();
            $site->allowedSubdomains()->delete();
            $site->delete();
        }
        $user->delete();
        return redirect()->route('admin.index')->with('success', "User \"{$name}\" has been deleted.");
    }

    /**
     * GET /admin/sites/{site}
     * Show full details for a single site.
     */
    public function show(Site $site): View
    {
        $site->load(['user', 'gamToken', 'allowedSubdomains']);

        return view('admin.show', compact('site'));
    }

    /**
     * POST /admin/sites/{site}/suspend
     * Toggle suspension state.
     */
    public function suspend(Site $site): RedirectResponse
    {
        if ($site->isSuspended()) {
            $site->update(['suspended_at' => null]);
            try { Mail::to($site->user->email)->send(new AccountReinstatedMail()); } catch (\Exception $e) { \Illuminate\Support\Facades\Log::error('Mail failed: ' . $e->getMessage()); }
            $message = "Site \"{$site->url}\" has been unsuspended.";
        } else {
            $site->update(['suspended_at' => now()]);
            try { Mail::to($site->user->email)->send(new AccountSuspendedMail($site)); } catch (\Exception $e) { \Illuminate\Support\Facades\Log::error('Mail failed: ' . $e->getMessage()); }
            $message = "Site \"{$site->url}\" has been suspended.";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * DELETE /admin/sites/{site}
     * Permanently delete a site and all related records.
     */
    public function destroy(Site $site): RedirectResponse
    {
        $url = $site->url;

        // Delete related records first
        $site->gamToken()?->delete();
        $site->allowedSubdomains()->delete();
        $site->delete();

        return redirect()->route('admin.index')->with('success', "Site \"{$url}\" has been permanently deleted.");
    }

    /**
     * POST /admin/sites/{site}/note
     * Save an admin note against the site.
     */
    public function updateNote(Request $request, Site $site): RedirectResponse
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:5000'],
        ]);

        $site->update(['admin_note' => $request->input('admin_note')]);

        return redirect()->back()->with('success', 'Admin note saved.');
    }
}
