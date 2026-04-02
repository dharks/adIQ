@extends('layouts.app')
@section('title', 'Publisher — ' . ($site->url ?: 'Detail'))
@section('page-title', 'Publisher Detail')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

{{-- Breadcrumb + title --}}
<div class="breadcrumb">
    <a href="{{ route('admin.index') }}">Publisher Console</a>
    <span class="breadcrumb-sep">›</span>
    <span style="color:var(--g700);">{{ parse_url($site->url ?: $site->activated_url, PHP_URL_HOST) ?: 'Unactivated Publisher' }}</span>
</div>

<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
    <div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px;">
            <h2 style="font-size:18px;font-weight:700;color:var(--g900);">
                {{ $site->url ?: ($site->activated_url ?: 'Unactivated Publisher') }}
            </h2>
            @if($site->isSuspended())
                <span class="badge badge-red">Suspended</span>
            @elseif($site->activated_at)
                <span class="badge badge-green">Active</span>
            @else
                <span class="badge badge-gray">Inactive</span>
            @endif
            @if($site->gam_connected)
                <span class="badge badge-teal">GAM Connected</span>
            @endif
        </div>
        <p style="font-size:13px;color:var(--g500);">Registered {{ $site->created_at->format('d M Y, H:i') }}</p>
    </div>
    <form method="POST" action="{{ route('admin.sites.suspend', $site) }}">
        @csrf
        <button type="submit"
                class="btn btn-sm {{ $site->isSuspended() ? 'btn-primary' : '' }}"
                style="{{ $site->isSuspended() ? '' : 'border-color:#FCD34D;color:var(--amber-txt);background:#fff;' }}"
                onclick="return confirm('{{ $site->isSuspended() ? 'Reinstate this publisher?' : 'Suspend this publisher? Their license will stop working immediately.' }}')">
            {{ $site->isSuspended() ? 'Reinstate Publisher' : 'Suspend Publisher' }}
        </button>
    </form>
</div>

{{-- Detail grid --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    {{-- Site details --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Property Details</div>

        <div class="detail-row">
            <span class="detail-label">Domain</span>
            <span class="detail-value">{{ $site->url ?: '—' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Activated URL</span>
            <span class="detail-value" style="font-size:13px;color:var(--g500);">{{ $site->activated_url ?: '—' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Access Key</span>
            <span class="detail-value">
                <button class="key-chip" style="font-size:11.5px;"
                        onclick="var btn=this;navigator.clipboard.writeText('{{ $site->license_key }}').then(function(){var o=btn.innerHTML;btn.textContent='Copied!';setTimeout(function(){btn.innerHTML=o},1500)})"
                        title="Click to copy">
                    <code style="font-family:monospace;letter-spacing:0.02em;">{{ $site->license_key }}</code>
                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                </button>
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Activated</span>
            <span class="detail-value">{{ $site->activated_at ? $site->activated_at->format('d M Y, H:i') : '—' }}</span>
        </div>
        @if($site->isSuspended())
        <div class="detail-row">
            <span class="detail-label">Suspended</span>
            <span class="detail-value" style="color:var(--red);">{{ $site->suspended_at->format('d M Y, H:i') }}</span>
        </div>
        @endif
    </div>

    {{-- Account owner --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Account Owner</div>

        @if($site->user)
            <div class="detail-row">
                <span class="detail-label">Name</span>
                <span class="detail-value">{{ $site->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $site->user->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Member since</span>
                <span class="detail-value">{{ $site->user->created_at->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total properties</span>
                <span class="detail-value">{{ $site->user->sites()->count() }}</span>
            </div>
        @else
            <p style="font-size:13px;color:var(--g500);">No account associated.</p>
        @endif
    </div>

    {{-- GAM --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Inventory Source — Google Ad Manager</div>

        @if($site->gam_connected)
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value"><span class="badge badge-teal">Connected</span></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Account</span>
                <span class="detail-value">{{ $site->gam_email ?: '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Network</span>
                <span class="detail-value">
                    {{ $site->gam_network_name ?: '—' }}
                    @if($site->gam_network_id)
                        <span style="font-size:12px;color:var(--g400);margin-left:6px;">#{{ $site->gam_network_id }}</span>
                    @endif
                </span>
            </div>
            @if($site->gamToken)
            <div class="detail-row">
                <span class="detail-label">Token expiry</span>
                <span class="detail-value" style="font-size:13px;">
                    @if($site->gamToken->expires_at)
                        @php $exp = \Carbon\Carbon::parse($site->gamToken->expires_at); @endphp
                        <span style="color:{{ $exp->isPast() ? 'var(--red)' : 'var(--g900)' }}">
                            {{ $exp->format('d M Y, H:i') }}
                            @if($exp->isPast()) <span class="badge badge-red" style="margin-left:6px;">Expired</span>@endif
                        </span>
                    @else
                        —
                    @endif
                </span>
            </div>
            @endif
        @else
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value"><span class="badge badge-gray">Not Connected</span></span>
            </div>
            <p style="font-size:13px;color:var(--g500);margin-top:8px;">Publisher has not connected a GAM account.</p>
        @endif
    </div>

    {{-- Approved origins --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Approved Origins ({{ $site->allowedSubdomains->count() }}/5)</div>

        @if($site->allowedSubdomains->isNotEmpty())
            <div style="display:flex;flex-direction:column;gap:6px;">
                @foreach($site->allowedSubdomains as $subdomain)
                <div style="display:flex;align-items:center;gap:6px;font-size:13px;padding:5px 0;border-bottom:1px solid var(--g100);">
                    <code style="background:var(--g100);padding:2px 7px;border-radius:4px;font-size:12px;border:1px solid var(--g200);">{{ $subdomain->subdomain }}</code>
                    <span style="color:var(--g400);">.{{ $site->domain }}</span>
                </div>
                @endforeach
            </div>
            @if($site->domain)
                <p style="font-size:12px;color:var(--g400);margin-top:12px;">Root: <strong>{{ $site->domain }}</strong></p>
            @endif
        @else
            <p style="font-size:13px;color:var(--g500);">No additional origins approved.</p>
            @if($site->domain)
                <p style="font-size:12px;color:var(--g400);margin-top:8px;">Root: <strong>{{ $site->domain }}</strong></p>
            @endif
        @endif
    </div>
</div>

{{-- Admin note --}}
<div class="card">
    <div class="card-label">Internal Note</div>
    <form method="POST" action="{{ route('admin.sites.note', $site) }}">
        @csrf
        <textarea name="admin_note" class="form-textarea"
                  placeholder="Internal notes — only visible to admins…" maxlength="5000"
                  style="margin-bottom:12px;">{{ old('admin_note', $site->admin_note) }}</textarea>
        <button type="submit" class="btn btn-sm btn-outline">Save Note</button>
    </form>
</div>

{{-- Danger zone --}}
<div class="danger-zone">
    <div class="danger-label">Danger Zone</div>
    <p>Permanently delete this publisher, their GAM token, and all associated origin records. This action cannot be undone.</p>
    <form method="POST" action="{{ route('admin.sites.destroy', $site) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Permanently delete this publisher and ALL related data? This CANNOT be undone.')">
            Delete Publisher Permanently
        </button>
    </form>
</div>

@endsection
