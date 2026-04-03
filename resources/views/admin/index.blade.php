@extends('layouts.app')
@section('title', 'Publisher Console')
@section('page-title', 'Publisher Console')

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif

{{-- Stat row --}}
<div class="stat-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card">
        <div class="stat-label">Total Publishers</div>
        <div class="stat-value">{{ number_format($totalSites) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active Licenses</div>
        <div class="stat-value" style="color:var(--green)">{{ number_format($activeSites) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">GAM Connected</div>
        <div class="stat-value" style="color:var(--teal)">
            {{-- count sites with gam_connected --}}
            @php $gamCount = \App\Models\Site::where('gam_connected', true)->count(); @endphp
            {{ number_format($gamCount) }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Suspended</div>
        <div class="stat-value" style="color:var(--red)">{{ number_format($suspendedSites) }}</div>
    </div>
</div>

{{-- Search --}}
<div class="search-bar">
    <form method="GET" action="{{ route('admin.index') }}" style="display:flex;gap:10px;flex:1;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by domain, access key, or publisher email…"
            class="form-input" style="flex:1;max-width:480px;">
        <button type="submit" class="btn btn-primary btn-sm">Search</button>
        @if($search)
        <a href="{{ route('admin.index') }}" class="btn btn-outline btn-sm">Clear</a>
        @endif
    </form>
</div>

{{-- Publishers table --}}
<div class="tbl-wrap">
    @if($sites->isEmpty())
    <div class="empty-state">
        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" />
            <path d="M21 21l-4.35-4.35" />
        </svg>
        <p>{{ $search ? 'No publishers found matching "' . e($search) . '".' : 'No publishers yet.' }}</p>
    </div>
    @else
    <table class="tbl">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Publisher</th>
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
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                    title="{{ $site->url ?: $site->activated_url }}">
                    <span style="font-weight:500;color:var(--g900);">
                        {{ parse_url($site->url ?: $site->activated_url, PHP_URL_HOST) ?: ($site->url ?: '-') }}
                    </span>
                </td>
                <td style="font-size:12.5px;color:var(--g500);">
                    {{ $site->user?->email ?? '-' }}
                </td>
                <td>
                    <button class="key-chip"
                        title="{{ $site->license_key }}"
                        onclick="var btn=this;navigator.clipboard.writeText('{{ $site->license_key }}').then(function(){var o=btn.innerHTML;btn.textContent='Copied!';setTimeout(function(){btn.innerHTML=o},1200)})">
                        {{ substr($site->license_key, 0, 8) }}&hellip;
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="9" y="9" width="13" height="13" rx="2" />
                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                        </svg>
                    </button>
                </td>
                <td>
                    @if($site->isSuspended())
                    <span class="badge badge-red">Suspended</span>
                    @elseif($site->activated_at)
                    <span class="badge badge-green">Active</span>
                    @else
                    <span class="badge badge-gray">Inactive</span>
                    @endif
                </td>
                <td>
                    @if($site->gam_connected)
                    <span class="badge badge-teal" title="{{ $site->gam_email }}">Connected</span>
                    @else
                    <span class="badge badge-gray">-</span>
                    @endif
                </td>
                <td style="font-size:12px;color:var(--g400);white-space:nowrap;">
                    {{ $site->created_at->format('d M Y') }}
                </td>
                <td>
                    <div style="display:flex;gap:5px;align-items:center;white-space:nowrap;">
                        <a href="{{ route('admin.sites.show', $site) }}" class="btn btn-xs btn-outline">View</a>

                        <form method="POST" action="{{ route('admin.sites.suspend', $site) }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-xs {{ $site->isSuspended() ? 'btn-primary' : '' }}"
                                style="{{ $site->isSuspended() ? '' : 'background:#fff;border-color:#FCD34D;color:var(--amber-txt);' }}"
                                onclick="return confirm('{{ $site->isSuspended() ? 'Unsuspend this publisher?' : 'Suspend this publisher? Their license will stop working immediately.' }}')">
                                {{ $site->isSuspended() ? 'Reinstate' : 'Suspend' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.sites.destroy', $site) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm('Permanently delete this publisher and all data? This cannot be undone.')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@if($sites->hasPages())
<div class="pagination">
    @if($sites->onFirstPage())
    <span class="pg-disabled">&laquo; Prev</span>
    @else
    <a href="{{ $sites->previousPageUrl() }}">&laquo; Prev</a>
    @endif

    @foreach($sites->getUrlRange(max(1, $sites->currentPage()-3), min($sites->lastPage(), $sites->currentPage()+3)) as $page => $url)
    @if($page == $sites->currentPage())
    <span class="pg-active">{{ $page }}</span>
    @else
    <a href="{{ $url }}">{{ $page }}</a>
    @endif
    @endforeach

    @if($sites->hasMorePages())
    <a href="{{ $sites->nextPageUrl() }}">Next &raquo;</a>
    @else
    <span class="pg-disabled">Next &raquo;</span>
    @endif
</div>
@endif

@endsection