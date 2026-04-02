<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'adIQ by Percivo — Publisher Ad Management for WordPress')</title>
    <meta name="description" content="@yield('meta-description', 'Connect Google Ad Manager to WordPress. Deploy ad units, manage publisher licenses, and optimize ad inventory — without enterprise complexity.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:     #2DBDB5;
            --teal-d:   #1FA89F;
            --teal-l:   rgba(45,189,181,0.12);
            --dark:     #0D1117;
            --dark-2:   #161B27;
            --dark-3:   #1C2333;
            --dark-bd:  rgba(255,255,255,0.08);
            --g50:      #F8F9FB;
            --g100:     #F1F3F5;
            --g200:     #E2E5E9;
            --g400:     #9CA3AF;
            --g500:     #6B7280;
            --g700:     #374151;
            --g900:     #111827;
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--g900);
            background: #fff;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Nav ── */
        .mkt-nav {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(13,17,23,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--dark-bd);
            padding: 0 24px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-brand {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            line-height: 1;
        }
        .nav-brand .adiq  { font-size: 18px; font-weight: 800; color: #fff; letter-spacing: -0.4px; }
        .nav-brand .byp   { font-size: 9px; font-weight: 600; color: var(--teal); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 2px; }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 7px;
            transition: color .12s, background .12s;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-cta {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dark);
            background: var(--teal);
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 7px;
            transition: background .12s;
            margin-left: 4px;
        }
        .nav-cta:hover { background: var(--teal-d); }

        /* Mobile nav toggle */
        .nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
            border: none;
            background: none;
        }
        .nav-hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: rgba(255,255,255,0.7);
            border-radius: 2px;
            transition: all .2s;
        }
        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 300;
            background: var(--dark);
            padding: 24px;
            flex-direction: column;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .mobile-close {
            background: none;
            border: none;
            color: rgba(255,255,255,0.6);
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
        }
        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }
        .mobile-nav-link {
            font-size: 16px;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            padding: 14px 0;
            border-bottom: 1px solid var(--dark-bd);
        }
        .mobile-nav-cta {
            display: block;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
            background: var(--teal);
            text-decoration: none;
            padding: 14px;
            border-radius: 8px;
            margin-top: 24px;
        }

        /* ── Footer ── */
        .mkt-footer {
            background: var(--dark);
            border-top: 1px solid var(--dark-bd);
            padding: 48px 24px 32px;
        }
        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }
        .footer-brand .adiq  { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -0.4px; }
        .footer-brand .byp   { font-size: 9px; font-weight: 600; color: var(--teal); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 2px; display: block; margin-bottom: 14px; }
        .footer-brand p { font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.65; max-width: 260px; }
        .footer-col h4 { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px; }
        .footer-col a { display: block; font-size: 13.5px; color: rgba(255,255,255,0.5); text-decoration: none; margin-bottom: 10px; transition: color .12s; }
        .footer-col a:hover { color: #fff; }
        .footer-bottom {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 24px;
            border-top: 1px solid var(--dark-bd);
            font-size: 12px;
            color: rgba(255,255,255,0.2);
            flex-wrap: wrap;
            gap: 8px;
        }
        .footer-bottom a { color: rgba(255,255,255,0.3); text-decoration: none; }
        .footer-bottom a:hover { color: rgba(255,255,255,0.6); }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
            .footer-inner { grid-template-columns: 1fr; gap: 32px; }
            .footer-col { display: none; }
        }
    </style>
    @stack('head-styles')
</head>
<body>

    <!-- Nav -->
    <nav class="mkt-nav">
        <a href="{{ route('home') }}" class="nav-brand">
            <span class="adiq">adIQ</span>
            <span class="byp">by Percivo</span>
        </a>
        <div class="nav-links">
            <a href="#features" class="nav-link">Features</a>
            <a href="#how-it-works" class="nav-link">How it works</a>
            <a href="#technical" class="nav-link">Technical</a>
            @auth
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
            @endauth
        </div>
        <button class="nav-hamburger" onclick="document.getElementById('mobile-menu').classList.add('open')" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <a href="{{ route('home') }}" class="nav-brand" style="text-decoration:none;">
                <span style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-0.4px;">adIQ</span>
                <span style="font-size:9px;font-weight:600;color:var(--teal);text-transform:uppercase;letter-spacing:0.1em;display:block;margin-top:2px;">by Percivo</span>
            </a>
            <button class="mobile-close" onclick="document.getElementById('mobile-menu').classList.remove('open')">&times;</button>
        </div>
        <div class="mobile-nav-links">
            <a href="#features" class="mobile-nav-link" onclick="document.getElementById('mobile-menu').classList.remove('open')">Features</a>
            <a href="#how-it-works" class="mobile-nav-link" onclick="document.getElementById('mobile-menu').classList.remove('open')">How it works</a>
            <a href="#technical" class="mobile-nav-link" onclick="document.getElementById('mobile-menu').classList.remove('open')">Technical</a>
            @auth
                <a href="{{ route('dashboard') }}" class="mobile-nav-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="mobile-nav-link">Sign In</a>
            @endauth
        </div>
        @guest
        <a href="{{ route('register') }}" class="mobile-nav-cta">Get Started →</a>
        @endguest
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="mkt-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <span class="adiq">adIQ</span>
                <span class="byp">by Percivo</span>
                <p>Publisher-grade ad management for WordPress. Connect Google Ad Manager, manage inventory, and deploy ads without enterprise complexity.</p>
            </div>
            <div class="footer-col">
                <h4>Platform</h4>
                <a href="#features">Features</a>
                <a href="#how-it-works">How it works</a>
                <a href="#technical">Technical specs</a>
                <a href="{{ route('login') }}">Sign in</a>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="https://percivo.com" target="_blank" rel="noopener">Percivo</a>
                <a href="https://percivo.com/adIQ" target="_blank" rel="noopener">percivo.com/adIQ</a>
                <a href="https://app.percivo.io/login" target="_blank" rel="noopener">Publisher Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Percivo. adIQ by Percivo. All rights reserved.</span>
            <a href="https://percivo.com" target="_blank" rel="noopener">percivo.com</a>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
