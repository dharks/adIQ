<?php

namespace App\Http\Controllers;

use App\Models\PluginRelease;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PluginReleaseController extends Controller
{
    public function index(): View
    {
        $releases = PluginRelease::orderByDesc('id')->get();
        $latest   = PluginRelease::latest();

        return view('admin.plugin', compact('releases', 'latest'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'version'      => ['required', 'string', 'max:20', 'regex:/^\d+\.\d+\.\d+$/'],
            'requires_wp'  => ['required', 'string', 'max:10'],
            'requires_php' => ['required', 'string', 'max:10'],
            'tested_wp'    => ['required', 'string', 'max:10'],
            'changelog'    => ['nullable', 'string', 'max:5000'],
            'zip_file'     => ['nullable', 'file', 'mimes:zip', 'max:51200'], // 50 MB
        ]);

        $zipPath = null;

        if ($request->hasFile('zip_file') && $request->file('zip_file')->isValid()) {
            $filename = 'adiq-' . $validated['version'] . '.zip';
            $request->file('zip_file')->storeAs('plugin', $filename);
            $zipPath = 'plugin/' . $filename;

            // Also overwrite the canonical adiq.zip so existing installs that
            // use the unversioned URL still get the latest build.
            $request->file('zip_file')->storeAs('plugin', 'adiq.zip');
        }

        PluginRelease::create([
            'version'      => $validated['version'],
            'requires_wp'  => $validated['requires_wp'],
            'requires_php' => $validated['requires_php'],
            'tested_wp'    => $validated['tested_wp'],
            'changelog'    => $validated['changelog'] ?? null,
            'zip_path'     => $zipPath,
            'is_active'    => true,
        ]);

        return redirect()->route('admin.plugin')->with('success', "Version {$validated['version']} published.");
    }

    public function destroy(PluginRelease $release): RedirectResponse
    {
        // Delete the versioned zip if it exists and isn't the canonical adiq.zip
        if ($release->zip_path && $release->zip_path !== 'plugin/adiq.zip') {
            \Illuminate\Support\Facades\Storage::delete($release->zip_path);
        }

        $release->delete();

        return redirect()->route('admin.plugin')->with('success', 'Release deleted.');
    }
}
