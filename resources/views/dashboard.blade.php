@extends('layouts.app')
@section('title', 'Properties')
@section('page-title', 'Properties')

@section('content')

{{-- Stat row --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Properties</div>
        <div class="stat-value">{{ $sites->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Licensed</div>
        <div class="stat-value" style="color:var(--green)">{{ $sites->where('activated', true)->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">GAM Connected</div>
        <div class="stat-value" style="color:var(--teal)">{{ $sites->where('gam_connected', true)->count() }}</div>
    </div>
</div>

{{-- Plugin download --}}
<div class="card" style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;">
    <div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
            </svg>
            <span style="font-size:14px;font-weight:600;color:var(--g900);">adIQ WordPress Plugin</span>
            <span class="badge badge-teal">v{{ $pluginVersion }}</span>
        </div>
        <p style="font-size:13px;color:var(--g500);margin-left:28px;">Download and install on your WordPress property to activate your license and connect GAM.</p>
    </div>
    @if($sites->isNotEmpty())
        <a href="{{ url('/api/v1/plugin/download') }}?license_key={{ $sites->first()->license_key }}"
           class="btn btn-primary" style="flex-shrink:0;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
            </svg>
            Download Plugin
        </a>
    @else
        <span class="btn btn-primary" style="opacity:0.4;cursor:not-allowed;flex-shrink:0;" title="Register a property first">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
            </svg>
            Download Plugin
        </span>
    @endif
</div>

{{-- Register new property --}}
<div class="card">
    <div class="card-title">Register a Property</div>
    <form method="POST" action="{{ route('sites.add') }}" class="form-row">
        @csrf
        <input type="url" name="url" required placeholder="https://yourdomain.com"
               class="form-input" value="{{ old('url') }}" style="max-width:420px;">
        <button type="submit" class="btn btn-primary">Add Property</button>
    </form>
    @error('url')<div class="form-err" style="margin-top:8px;">{{ $message }}</div>@enderror
    <p class="form-hint" style="margin-top:8px;">A unique 32-character access key will be generated. Install the plugin on this domain to activate it.</p>
</div>

{{-- Properties table --}}
@if($sites->isEmpty())
    <div class="tbl-wrap">
        <div class="empty-state">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            <p>No properties registered yet. Add your first one above.</p>
        </div>
    </div>
@else
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Access Key</th>
                    <th>License</th>
                    <th>GAM</th>
                    <th>Registered</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sites as $site)
                <tr>
                    <td>
                        <a href="{{ $site->url }}" target="_blank" rel="noopener"
                           style="color:var(--g900);font-weight:500;text-decoration:none;display:flex;align-items:center;gap:6px;">
                            {{ parse_url($site->url, PHP_URL_HOST) ?: $site->url }}
                            <svg width="11" height="11" fill="none" stroke="var(--g400)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                    </td>
                    <td>
                        <button class="key-chip" id="key-{{ $site->id }}"
                                onclick="adiqCopy('{{ $site->id }}', '{{ $site->license_key }}')"
                                title="Click to copy">
                            {{ substr($site->license_key, 0, 8) }}&hellip;{{ substr($site->license_key, -4) }}
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        </button>
                    </td>
                    <td>
                        @if($site->isSuspended())
                            <span class="badge badge-red">Suspended</span>
                        @elseif($site->activated)
                            <span class="badge badge-green">Active</span>
                        @else
                            <span class="badge badge-gray">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if($site->gam_connected)
                            <span class="badge badge-teal">{{ $site->gam_network_name ?: 'Connected' }}</span>
                        @else
                            <span class="badge badge-gray">Not connected</span>
                        @endif
                    </td>
                    <td style="color:var(--g400);font-size:12px;white-space:nowrap;">
                        {{ $site->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('sites.show', $site) }}" class="btn btn-xs btn-outline">Manage</a>
                            <form method="POST" action="{{ route('sites.delete', $site) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger"
                                        onclick="return confirm('Remove {{ addslashes($site->url) }}? This will revoke its license immediately.')">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@push('scripts')
<script>
function adiqCopy(id, full) {
    navigator.clipboard.writeText(full).then(function() {
        var btn = document.getElementById('key-' + id);
        var orig = btn.innerHTML;
        btn.textContent = 'Copied!';
        setTimeout(function() { btn.innerHTML = orig; }, 1500);
    });
}
</script>
@endpush
@endsection
