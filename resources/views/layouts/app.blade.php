<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — adIQ by Percivo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:      #2DBDB5;
            --teal-d:    #1FA89F;
            --teal-bg:   rgba(45,189,181,0.1);
            --dark:      #0D1117;
            --dark-2:    #161B27;
            --dark-3:    #1C2333;
            --dark-bd:   rgba(255,255,255,0.07);
            --g50:       #F8F9FB;
            --g100:      #F1F3F5;
            --g200:      #E2E5E9;
            --g300:      #CDD2D8;
            --g400:      #9CA3AF;
            --g500:      #6B7280;
            --g700:      #374151;
            --g900:      #111827;
            --green:     #16A34A;
            --green-bg:  #DCFCE7;
            --green-txt: #15803D;
            --red:       #DC2626;
            --red-bg:    #FEE2E2;
            --red-txt:   #991B1B;
            --amber:     #D97706;
            --amber-bg:  #FEF3C7;
            --amber-txt: #92400E;
            --blue-bg:   #DBEAFE;
            --blue-txt:  #1D4ED8;
            --sidebar-w: 224px;
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--g900);
            background: var(--g50);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ════════════════════════════════
           SIDEBAR
        ════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--dark);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            border-right: 1px solid var(--dark-bd);
        }
        .sidebar-brand {
            padding: 20px 20px 18px;
            border-bottom: 1px solid var(--dark-bd);
            text-decoration: none;
            display: block;
        }
        .sidebar-brand img {
            height: 26px;
            width: auto;
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }
        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 12px 10px 6px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            transition: background .12s, color .12s;
            margin-bottom: 2px;
        }
        .nav-link:hover {
            background: var(--dark-3);
            color: rgba(255,255,255,0.9);
        }
        .nav-link.active {
            background: var(--teal-bg);
            color: var(--teal);
        }
        .nav-link svg {
            flex-shrink: 0;
            opacity: 0.7;
        }
        .nav-link.active svg { opacity: 1; }

        .nav-divider {
            border: none;
            border-top: 1px solid var(--dark-bd);
            margin: 10px 0;
        }

        .sidebar-footer {
            padding: 12px 10px 16px;
            border-top: 1px solid var(--dark-bd);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            margin-bottom: 6px;
        }
        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--teal-bg);
            border: 1px solid rgba(45,189,181,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--teal);
            flex-shrink: 0;
        }
        .user-info { overflow: hidden; }
        .user-name {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-role {
            font-size: 10px;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 8px 10px;
            background: none;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.35);
            cursor: pointer;
            font-family: inherit;
            transition: background .12s, color .12s;
            text-align: left;
        }
        .sidebar-logout:hover {
            background: rgba(220,38,38,0.1);
            color: #FCA5A5;
        }

        /* ════════════════════════════════
           MAIN AREA
        ════════════════════════════════ */
        .page-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top bar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--g200);
            padding: 0 32px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--g900);
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            background: var(--teal-bg);
            color: var(--teal);
            border: 1px solid rgba(45,189,181,0.25);
        }

        /* Content */
        .page-content {
            flex: 1;
            padding: 32px;
        }

        /* ════════════════════════════════
           ALERTS
        ════════════════════════════════ */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13.5px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-success { background: #F0FDF4; color: var(--green-txt); border: 1px solid #BBF7D0; }
        .alert-error   { background: #FEF2F2; color: var(--red-txt);   border: 1px solid #FECACA; }

        /* ════════════════════════════════
           CARDS
        ════════════════════════════════ */
        .card {
            background: #fff;
            border: 1px solid var(--g200);
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--g900);
            margin-bottom: 16px;
        }
        .card-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--g400);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        /* ════════════════════════════════
           STAT CARDS
        ════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid var(--g200);
            border-radius: 10px;
            padding: 18px 20px;
        }
        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--g400);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--g900);
            line-height: 1;
        }

        /* ════════════════════════════════
           TABLES
        ════════════════════════════════ */
        .tbl-wrap {
            background: #fff;
            border: 1px solid var(--g200);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }
        .tbl th {
            background: var(--g50);
            font-size: 11px;
            font-weight: 600;
            color: var(--g500);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid var(--g200);
            white-space: nowrap;
        }
        .tbl td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--g100);
            font-size: 13.5px;
            vertical-align: middle;
            color: var(--g700);
        }
        .tbl tbody tr:last-child td { border-bottom: none; }
        .tbl tbody tr:hover td { background: var(--g50); }

        /* ════════════════════════════════
           BADGES
        ════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.7;
        }
        .badge-green  { background: var(--green-bg);  color: var(--green-txt); }
        .badge-gray   { background: var(--g100);       color: var(--g500); }
        .badge-teal   { background: rgba(45,189,181,0.12); color: var(--teal-d); }
        .badge-red    { background: var(--red-bg);    color: var(--red-txt); }
        .badge-amber  { background: var(--amber-bg);  color: var(--amber-txt); }
        .badge-blue   { background: var(--blue-bg);   color: var(--blue-txt); }

        /* ════════════════════════════════
           BUTTONS
        ════════════════════════════════ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all .12s;
            font-family: inherit;
            line-height: 1;
            white-space: nowrap;
        }
        .btn-primary { background: var(--teal);    color: #fff; border-color: var(--teal); }
        .btn-primary:hover { background: var(--teal-d); border-color: var(--teal-d); }
        .btn-outline { background: #fff; color: var(--g700); border-color: var(--g200); }
        .btn-outline:hover { background: var(--g50); border-color: var(--g300); }
        .btn-danger  { background: #fff; color: var(--red); border-color: #FECACA; }
        .btn-danger:hover { background: var(--red-bg); }
        .btn-sm { padding: 6px 12px; font-size: 12.5px; }
        .btn-xs { padding: 4px 10px; font-size: 12px; }

        /* ════════════════════════════════
           FORMS
        ════════════════════════════════ */
        .form-row {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .form-input {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid var(--g200);
            border-radius: 7px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--g900);
            background: var(--g50);
            transition: border-color .15s, box-shadow .15s;
        }
        .form-input:focus {
            border-color: var(--teal);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45,189,181,.1);
            background: #fff;
        }
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--g700);
            margin-bottom: 5px;
        }
        .form-group .form-input { width: 100%; }
        .form-err { font-size: 12px; color: var(--red); margin-top: 4px; }
        .form-hint { font-size: 12px; color: var(--g400); margin-top: 4px; }

        /* ════════════════════════════════
           KEY (license key display)
        ════════════════════════════════ */
        .key-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-family: 'SF Mono', 'Fira Code', monospace;
            background: var(--g100);
            color: var(--g700);
            padding: 3px 8px;
            border-radius: 5px;
            border: 1px solid var(--g200);
            cursor: pointer;
            transition: background .1s;
        }
        .key-chip:hover { background: var(--g200); }

        /* Detail rows */
        .detail-row {
            display: flex;
            align-items: baseline;
            padding: 10px 0;
            border-bottom: 1px solid var(--g100);
            gap: 16px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--g400);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            flex-shrink: 0;
            width: 150px;
        }
        .detail-value { font-size: 13.5px; color: var(--g900); word-break: break-all; }

        /* Section header */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .section-header h2 {
            font-size: 16px;
            font-weight: 700;
            color: var(--g900);
        }
        .section-header p {
            font-size: 13px;
            color: var(--g500);
            margin-top: 2px;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--g400);
            margin-bottom: 24px;
        }
        .breadcrumb a { color: var(--g500); text-decoration: none; }
        .breadcrumb a:hover { color: var(--g900); }
        .breadcrumb-sep { color: var(--g300); font-size: 12px; }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 4px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            padding: 6px 12px;
            border: 1px solid var(--g200);
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            color: var(--g700);
            background: #fff;
        }
        .pagination a:hover { background: var(--g50); }
        .pagination .pg-active { background: var(--teal); color: #fff; border-color: var(--teal); }
        .pagination .pg-disabled { color: var(--g400); pointer-events: none; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--g500);
        }
        .empty-state svg { margin: 0 auto 16px; display: block; opacity: 0.25; }
        .empty-state p { font-size: 14px; }

        /* Danger zone */
        .danger-zone {
            background: #fff;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 22px 24px;
            margin-top: 20px;
        }
        .danger-zone .danger-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--red);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
        }
        .danger-zone p { font-size: 13px; color: var(--g500); margin-bottom: 16px; }

        /* Textarea */
        .form-textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px 14px;
            border: 1.5px solid var(--g200);
            border-radius: 7px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--g900);
            resize: vertical;
            background: var(--g50);
        }
        .form-textarea:focus {
            border-color: var(--teal);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45,189,181,.1);
            background: #fff;
        }

        /* Search bar */
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .sidebar { display: none; }
            .page-wrap { margin-left: 0; }
        }
        @media (max-width: 640px) {
            .page-content { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/adIQ-black-bg.png') }}" alt="adIQ by Percivo">
        </a>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Publisher</div>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('sites.*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Properties
            </a>

            @if(Auth::user()->is_admin)
            <hr class="nav-divider">
            <div class="nav-section-label">Admin</div>
            <a href="{{ route('admin.index') }}"
               class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Publisher Console
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ Auth::user()->is_admin ? 'Admin' : 'Publisher' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Page wrap -->
    <div class="page-wrap">
        <!-- Top bar -->
        <header class="topbar">
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
            <div class="topbar-right">
                @if(Auth::user()->is_admin)
                    <span class="topbar-badge">Admin</span>
                @endif
            </div>
        </header>

        <!-- Main content -->
        <main class="page-content">
            @if(session('flash') || session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('flash') ?? session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
