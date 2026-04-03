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
        <div class="stat-label">Registered Users</div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active Licenses</div>
        <div class="stat-value" style="color:var(--green)">{{ number_format($activeSites) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">GAM Connected</div>
        <div class="stat-value" style="color:var(--teal)">
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
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, domain, or license key..."
            class="form-input" style="flex:1;max-width:480px;">
        <button type="submit" class="btn btn-primary btn-sm">Search</button>
        @if($search)
        <a href="{{ route('admin.index') }}" class="btn btn-outline btn-sm">Clear</a>
        @endif
    </form>
</div>

{{-- Publishers table --}}
<div class="tbl-wrap">
    @if($users->isEmpty())
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
                <th>Publisher</th>
                <th>Sites</th>
                <th>Primary Domain</th>
                <th>License</th>
                <th>GAM</th>
                <th>Joined</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @php
                $primarySite = $user->sites->first();
                $hasSites    = $user->sites->isNotEmpty();
                $isAnySuspended = $user->sites->contains(fn($s) => $s->isSuspended());
                $isAnyActive    = $user->sites->contains(fn($s) => !is_null($s->activated_at) && !$s->isSuspended());
                $isAnyGam       = $user->sites->contains(fn($s) => $s->gam_connected);
            @endphp
            <tr>
                <td>
                    <div style="font-weight:500;color:var(--g900);font-size:13.5px;">{{ $user->name }}</div>
                    <div style="font-size:12px;color:var(--g500);margin-top:1px;">{{ $user->email }}</div>
                </td>
                <td style="text-align:center;">
                    @if($hasSites)
                        <span style="font-weight:600;color:var(--g900);">{{ $user->sites->count() }}</span>
                    @else
                        <span style="color:var(--g400);font-size:12px;">none</span>
                    @endif
                </td>
                <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    @if($primarySite)
                        <span style="font-size:13px;color:var(--g700);">
                            {{ $primarySite->domain ?: parse_url($primarySite->url, PHP_URL_HOST) ?: $primarySite->url }}
                        </span>
                        @if($user->sites->count() > 1)
                            <span style="font-size:11px;color:var(--g400);margin-left:4px;">+{{ $user->sites->count() - 1 }} more</span>
                        @endif
                    @else
                        <span style="font-size:12px;color:var(--g400);">No site added</span>
                    @endif
                </td>
                <td>
                    @if($isAnySuspended)
                        <span class="badge badge-red">Suspended</span>
                    @elseif($isAnyActive)
                        <span class="badge badge-green">Active</span>
                    @elseif($hasSites)
                        <span class="badge badge-gray">Inactive</span>
                    @else
                        <span class="badge badge-gray">No site</span>
                    @endif
                </td>
                <td>
                    @if($isAnyGam)
                        <span class="badge badge-teal">Connected</span>
                    @else
                        <span class="badge badge-gray">-</span>
                    @endif
                </td>
                <td style="font-size:12px;color:var(--g400);white-space:nowrap;">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td>
                    <div style="display:flex;gap:5px;align-items:center;white-space:nowrap;">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-xs btn-outline">View</a>

                        @if($primarySite)
                            <form method="POST" action="{{ route('admin.sites.suspend', $primarySite) }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-xs {{ $isAnySuspended ? 'btn-primary' : '' }}"
                                    style="{{ $isAnySuspended ? '' : 'background:#fff;border-color:#FCD34D;color:var(--amber-txt);' }}"
                                    onclick="return confirm('{{ $isAnySuspended ? 'Reinstate this publisher?' : 'Suspend this publisher? Their license will stop working immediately.' }}')">
                                    {{ $isAnySuspended ? 'Reinstate' : 'Suspend' }}
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm('Permanently delete this user and all their data? This cannot be undone.')">
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

@if($users->hasPages())
<div class="pagination">
    @if($users->onFirstPage())
    <span class="pg-disabled">&laquo; Prev</span>
    @else
    <a href="{{ $users->previousPageUrl() }}">&laquo; Prev</a>
    @endif

    @foreach($users->getUrlRange(max(1, $users->currentPage()-3), min($users->lastPage(), $users->currentPage()+3)) as $page => $url)
    @if($page == $users->currentPage())
    <span class="pg-active">{{ $page }}</span>
    @else
    <a href="{{ $url }}">{{ $page }}</a>
    @endif
    @endforeach

    @if($users->hasMorePages())
    <a href="{{ $users->nextPageUrl() }}">Next &raquo;</a>
    @else
    <span class="pg-disabled">Next &raquo;</span>
    @endif
</div>
@endif

@endsection
