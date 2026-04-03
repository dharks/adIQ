@extends('layouts.app')
@section('title', 'User - ' . $user->name)
@section('page-title', 'User Profile')

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('admin.index') }}">Publisher Console</a>
    <span class="breadcrumb-sep">›</span>
    <span style="color:var(--g700);">{{ $user->name }}</span>
</div>

<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
    <div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px;">
            <h2 style="font-size:18px;font-weight:700;color:var(--g900);">{{ $user->name }}</h2>
            @if($user->sites->isNotEmpty())
                <span class="badge badge-teal">{{ $user->sites->count() }} {{ Str::plural('property', $user->sites->count()) }}</span>
            @else
                <span class="badge badge-gray">No properties</span>
            @endif
        </div>
        <p style="font-size:13px;color:var(--g500);">Joined {{ $user->created_at->format('d M Y, H:i') }}</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    {{-- Account details --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Account Details</div>

        <div class="detail-row">
            <span class="detail-label">Full name</span>
            <span class="detail-value">{{ $user->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $user->email }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email verified</span>
            <span class="detail-value">
                @if($user->email_verified_at)
                    <span class="badge badge-green">{{ $user->email_verified_at->format('d M Y') }}</span>
                @else
                    <span class="badge badge-gray">Not verified</span>
                @endif
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Member since</span>
            <span class="detail-value">{{ $user->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Total properties</span>
            <span class="detail-value">{{ $user->sites->count() }}</span>
        </div>
    </div>

    {{-- KYC / Location --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">KYC / Location</div>

        <div class="detail-row">
            <span class="detail-label">Country</span>
            <span class="detail-value">{{ $user->country ?: '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">State / Province</span>
            <span class="detail-value">{{ $user->state ?: '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">City</span>
            <span class="detail-value">{{ $user->city ?: '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Address</span>
            <span class="detail-value">{{ $user->address ?: '-' }}</span>
        </div>
    </div>
</div>

{{-- Properties --}}
@if($user->sites->isNotEmpty())
<div class="card-label" style="margin-bottom:12px;">Properties</div>
<div style="display:flex;flex-direction:column;gap:14px;margin-bottom:24px;">
    @foreach($user->sites as $site)
    <div class="card" style="margin-bottom:0;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <span style="font-weight:600;font-size:14px;color:var(--g900);">
                    {{ $site->domain ?: parse_url($site->url, PHP_URL_HOST) ?: $site->url }}
                </span>
                @if($site->isSuspended())
                    <span class="badge badge-red">Suspended</span>
                @elseif($site->activated_at)
                    <span class="badge badge-green">Active</span>
                @else
                    <span class="badge badge-gray">Inactive</span>
                @endif
                @if($site->gam_connected)
                    <span class="badge badge-teal">GAM</span>
                @endif
            </div>
            <a href="{{ route('admin.sites.show', $site) }}" class="btn btn-xs btn-outline">Manage</a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0;font-size:12.5px;">
            <div>
                <div style="color:var(--g400);margin-bottom:2px;">Registered URL</div>
                <div style="color:var(--g700);">{{ $site->url ?: '-' }}</div>
            </div>
            <div>
                <div style="color:var(--g400);margin-bottom:2px;">License key</div>
                <div>
                    <button class="key-chip" style="font-size:11px;"
                        onclick="var btn=this;navigator.clipboard.writeText('{{ $site->license_key }}').then(function(){var o=btn.innerHTML;btn.textContent='Copied!';setTimeout(function(){btn.innerHTML=o},1200)})">
                        {{ substr($site->license_key, 0, 12) }}&hellip;
                    </button>
                </div>
            </div>
            <div>
                <div style="color:var(--g400);margin-bottom:2px;">Activated</div>
                <div style="color:var(--g700);">{{ $site->activated_at ? $site->activated_at->format('d M Y') : 'Not yet' }}</div>
            </div>
        </div>

        @if($site->allowedSubdomains->isNotEmpty())
        <div style="margin-top:12px;padding-top:10px;border-top:1px solid var(--g100);font-size:12px;color:var(--g500);">
            Approved origins:
            @foreach($site->allowedSubdomains as $sub)
                <code style="background:var(--g100);padding:1px 6px;border-radius:4px;border:1px solid var(--g200);margin-left:4px;">{{ $sub->subdomain }}.{{ $site->domain }}</code>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>
@else
<div class="card" style="margin-bottom:24px;">
    <p style="font-size:13.5px;color:var(--g500);text-align:center;padding:8px 0;">
        This user has not added any properties yet.
    </p>
</div>
@endif

{{-- Danger zone --}}
<div class="danger-zone">
    <div class="danger-label">Danger Zone</div>
    <p>Permanently delete this user account, all their properties, GAM tokens, and origin records. This cannot be undone.</p>
    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('Permanently delete {{ $user->email }} and ALL their data? This CANNOT be undone.')">
            Delete User Permanently
        </button>
    </form>
</div>

@endsection
