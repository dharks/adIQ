@extends('layouts.marketing')
@section('title', 'adIQ by Percivo — Publisher Ad Management for WordPress')

@push('head-styles')
<style>
/* ══════════════════════════════════════════════
   SHARED
══════════════════════════════════════════════ */
.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
}
.tag-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(45,189,181,0.1);
    border: 1px solid rgba(45,189,181,0.25);
    color: var(--teal);
    font-size: 12px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 20px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.tag-pill::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--teal);
    flex-shrink: 0;
}

/* ══════════════════════════════════════════════
   HERO
══════════════════════════════════════════════ */
.hero {
    background: var(--dark);
    padding: 100px 24px 80px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(45,189,181,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(45,189,181,0.04) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}
.hero::after {
    content: '';
    position: absolute;
    top: -200px; left: 50%;
    transform: translateX(-50%);
    width: 800px; height: 600px;
    background: radial-gradient(ellipse at center, rgba(45,189,181,0.14) 0%, transparent 65%);
    pointer-events: none;
}
.hero-inner {
    position: relative;
    z-index: 1;
    max-width: 820px;
    margin: 0 auto;
}
.hero-tag { margin-bottom: 28px; }
.hero h1 {
    font-size: clamp(36px, 6vw, 68px);
    font-weight: 900;
    color: #fff;
    line-height: 1.08;
    letter-spacing: -2px;
    margin-bottom: 24px;
}
.hero h1 .accent { color: var(--teal); }
.hero-sub {
    font-size: clamp(16px, 2.2vw, 19px);
    color: rgba(255,255,255,0.5);
    line-height: 1.65;
    max-width: 620px;
    margin: 0 auto 40px;
    font-weight: 400;
}
.hero-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 64px;
}
.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--teal);
    color: var(--dark);
    font-size: 15px;
    font-weight: 700;
    padding: 14px 28px;
    border-radius: 8px;
    text-decoration: none;
    transition: background .12s, transform .12s;
    letter-spacing: -0.01em;
}
.btn-hero-primary:hover { background: var(--teal-d); transform: translateY(-1px); }
.btn-hero-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.8);
    font-size: 15px;
    font-weight: 500;
    padding: 14px 24px;
    border-radius: 8px;
    text-decoration: none;
    transition: background .12s;
}
.btn-hero-secondary:hover { background: rgba(255,255,255,0.1); }

/* Dashboard mockup */
.hero-mockup {
    max-width: 900px;
    margin: 0 auto;
    background: var(--dark-2);
    border: 1px solid var(--dark-bd);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 40px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04);
}
.mockup-bar {
    background: var(--dark-3);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid var(--dark-bd);
}
.mockup-dot { width: 10px; height: 10px; border-radius: 50%; }
.mockup-url {
    flex: 1;
    background: rgba(255,255,255,0.05);
    border-radius: 5px;
    padding: 5px 12px;
    font-size: 11px;
    color: rgba(255,255,255,0.3);
    font-family: monospace;
    margin: 0 8px;
}
.mockup-body { display: flex; height: 320px; }
.mockup-sidebar {
    width: 180px;
    flex-shrink: 0;
    background: #0D1117;
    border-right: 1px solid var(--dark-bd);
    padding: 16px 10px;
}
.mockup-brand {
    padding: 4px 8px 16px;
    border-bottom: 1px solid var(--dark-bd);
    margin-bottom: 12px;
}
.mockup-brand .m-adiq { font-size: 14px; font-weight: 800; color: #fff; }
.mockup-brand .m-byp  { font-size: 7px; font-weight: 600; color: var(--teal); text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-top: 1px; }
.mockup-nav-item {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 8px; border-radius: 6px; margin-bottom: 3px;
    font-size: 11px; font-weight: 500; color: rgba(255,255,255,0.4);
}
.mockup-nav-item.active { background: rgba(45,189,181,0.12); color: var(--teal); }
.mockup-nav-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
.mockup-main { flex: 1; background: #F8F9FB; padding: 20px; overflow: hidden; }
.mockup-topbar {
    background: #fff; border: 1px solid #E2E5E9; border-radius: 7px;
    padding: 10px 14px; font-size: 11px; font-weight: 600; color: #374151; margin-bottom: 16px;
}
.mockup-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 14px; }
.mockup-stat { background: #fff; border: 1px solid #E2E5E9; border-radius: 7px; padding: 12px; }
.mockup-stat-label { font-size: 8px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
.mockup-stat-val   { font-size: 18px; font-weight: 700; color: #111827; line-height: 1; }
.mockup-table { background: #fff; border: 1px solid #E2E5E9; border-radius: 7px; overflow: hidden; }
.mockup-th {
    display: grid; grid-template-columns: 2fr 1.5fr 0.8fr 0.8fr;
    background: #F8F9FB; padding: 8px 12px; border-bottom: 1px solid #E2E5E9;
}
.mockup-th span { font-size: 8px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; }
.mockup-row {
    display: grid; grid-template-columns: 2fr 1.5fr 0.8fr 0.8fr;
    padding: 9px 12px; border-bottom: 1px solid #F1F3F5; align-items: center;
}
.mockup-row:last-child { border-bottom: none; }
.mockup-row span { font-size: 9px; color: #374151; font-weight: 500; }
.mockup-badge {
    display: inline-flex; align-items: center; gap: 3px;
    font-size: 8px; font-weight: 700; padding: 2px 6px; border-radius: 10px;
}
.mb-green { background: #DCFCE7; color: #15803D; }
.mb-gray  { background: #F1F3F5; color: #6B7280; }
.mb-teal  { background: rgba(45,189,181,0.12); color: #1FA89F; }

/* ══════════════════════════════════════════════
   STATS STRIP
══════════════════════════════════════════════ */
.stats-strip {
    background: #fff;
    border-top: 1px solid var(--g200);
    border-bottom: 1px solid var(--g200);
    padding: 40px 24px;
}
.stats-strip-inner {
    max-width: 1100px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;
}
.stat-item { text-align: center; padding: 16px; border-right: 1px solid var(--g200); }
.stat-item:last-child { border-right: none; }
.stat-num { font-size: 36px; font-weight: 900; color: var(--g900); letter-spacing: -1px; line-height: 1; margin-bottom: 4px; }
.stat-num .unit { color: var(--teal); }
.stat-desc { font-size: 13px; color: var(--g500); font-weight: 500; }

/* ══════════════════════════════════════════════
   FEATURES
══════════════════════════════════════════════ */
.features-section { padding: 100px 24px; background: var(--g50); }
.section-header { text-align: center; margin-bottom: 64px; }
.section-header h2 {
    font-size: clamp(28px, 4vw, 42px); font-weight: 800; color: var(--g900);
    letter-spacing: -1px; line-height: 1.15; margin-bottom: 14px;
}
.section-header p { font-size: 17px; color: var(--g500); max-width: 560px; margin: 0 auto; line-height: 1.65; }
.features-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.feature-card {
    background: #fff; border: 1px solid var(--g200); border-radius: 12px; padding: 28px;
    transition: box-shadow .2s, border-color .2s, transform .2s;
}
.feature-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.07); border-color: rgba(45,189,181,0.3); transform: translateY(-2px); }
.feature-icon {
    width: 44px; height: 44px; border-radius: 10px; background: rgba(45,189,181,0.1);
    display: flex; align-items: center; justify-content: center; margin-bottom: 18px;
}
.feature-card h3 { font-size: 16px; font-weight: 700; color: var(--g900); margin-bottom: 8px; letter-spacing: -0.2px; }
.feature-card p  { font-size: 13.5px; color: var(--g500); line-height: 1.65; }
.feature-tag { display: inline-block; font-size: 10px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.06em; margin-top: 14px; }

/* ══════════════════════════════════════════════
   HOW IT WORKS
══════════════════════════════════════════════ */
.hiw-section { background: var(--dark); padding: 100px 24px; position: relative; overflow: hidden; }
.hiw-section::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(45,189,181,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(45,189,181,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
}
.hiw-inner { position: relative; z-index: 1; max-width: 1100px; margin: 0 auto; }
.hiw-section .section-header h2 { color: #fff; }
.hiw-section .section-header p  { color: rgba(255,255,255,0.45); }
.hiw-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; position: relative; }
.hiw-steps::before {
    content: '';
    position: absolute; top: 36px;
    left: calc(16.6% + 20px); right: calc(16.6% + 20px);
    height: 1px;
    background: linear-gradient(90deg, var(--teal), rgba(45,189,181,0.3), var(--teal));
    opacity: 0.4;
}
.hiw-step { text-align: center; padding: 0 12px; }
.hiw-step-num {
    width: 72px; height: 72px; border-radius: 50%;
    border: 1.5px solid rgba(45,189,181,0.3); background: rgba(45,189,181,0.07);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px; font-size: 22px; font-weight: 800; color: var(--teal); position: relative; z-index: 1;
}
.hiw-step h3 { font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 10px; letter-spacing: -0.2px; }
.hiw-step p  { font-size: 13.5px; color: rgba(255,255,255,0.4); line-height: 1.65; }
.hiw-step .step-detail {
    margin-top: 16px; font-size: 12px;
    background: rgba(255,255,255,0.04); border: 1px solid var(--dark-bd);
    border-radius: 8px; padding: 12px 14px; color: rgba(255,255,255,0.35);
    text-align: left; line-height: 1.6; font-family: 'SF Mono', 'Fira Code', monospace;
}
.step-detail .dt-comment { color: rgba(45,189,181,0.5); }
.step-detail .dt-key     { color: rgba(255,255,255,0.5); }
.step-detail .dt-val     { color: var(--teal); }

/* ══════════════════════════════════════════════
   TECHNICAL DEEP DIVE
══════════════════════════════════════════════ */
.tech-section { padding: 100px 24px; background: #fff; }
.tech-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.tech-content h2 { font-size: clamp(26px, 3.5vw, 38px); font-weight: 800; color: var(--g900); letter-spacing: -1px; line-height: 1.15; margin-bottom: 16px; }
.tech-content > p { font-size: 15px; color: var(--g500); line-height: 1.65; margin-bottom: 32px; }
.tech-list { list-style: none; display: flex; flex-direction: column; gap: 14px; }
.tech-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 14px; color: var(--g700); line-height: 1.5; }
.tech-list li::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--teal); flex-shrink: 0; margin-top: 6px; }
.tech-list strong { color: var(--g900); font-weight: 600; }
.tech-code { background: var(--dark); border: 1px solid var(--dark-bd); border-radius: 12px; overflow: hidden; box-shadow: 0 24px 64px rgba(0,0,0,0.15); }
.code-header { background: var(--dark-3); padding: 12px 16px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--dark-bd); }
.code-dot { width: 10px; height: 10px; border-radius: 50%; }
.code-title { font-size: 11px; color: rgba(255,255,255,0.3); font-family: monospace; margin-left: 4px; }
.code-body { padding: 24px; font-size: 12.5px; font-family: 'SF Mono', 'Fira Code', 'Consolas', monospace; line-height: 1.8; color: rgba(255,255,255,0.5); overflow-x: auto; }
.code-body .c-comment { color: rgba(255,255,255,0.2); font-style: italic; }
.code-body .c-key     { color: #79B8FF; }
.code-body .c-string  { color: #9ECBFF; }
.code-body .c-fn      { color: var(--teal); }

/* ══════════════════════════════════════════════
   GAM CARDS
══════════════════════════════════════════════ */
.gam-section { padding: 100px 24px; background: var(--g50); }
.gam-inner { max-width: 1100px; margin: 0 auto; }
.gam-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 56px; }
.gam-card { background: #fff; border: 1px solid var(--g200); border-radius: 12px; padding: 28px; position: relative; overflow: hidden; }
.gam-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--teal), rgba(45,189,181,0.3)); }
.gam-card-icon { width: 40px; height: 40px; border-radius: 9px; background: rgba(45,189,181,0.08); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
.gam-card h3 { font-size: 15px; font-weight: 700; color: var(--g900); margin-bottom: 8px; }
.gam-card p  { font-size: 13px; color: var(--g500); line-height: 1.65; }
.gam-card .chip-row { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 14px; }
.chip { font-size: 11px; font-weight: 600; background: var(--g100); color: var(--g700); padding: 3px 9px; border-radius: 20px; border: 1px solid var(--g200); font-family: monospace; }

/* ══════════════════════════════════════════════
   CTA
══════════════════════════════════════════════ */
.cta-section { padding: 100px 24px; background: var(--dark); text-align: center; position: relative; overflow: hidden; }
.cta-section::before {
    content: '';
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 700px; height: 500px;
    background: radial-gradient(ellipse at center, rgba(45,189,181,0.13) 0%, transparent 65%);
    pointer-events: none;
}
.cta-inner { position: relative; z-index: 1; max-width: 640px; margin: 0 auto; }
.cta-inner h2 { font-size: clamp(28px, 4.5vw, 48px); font-weight: 900; color: #fff; letter-spacing: -1.5px; line-height: 1.1; margin-bottom: 16px; }
.cta-inner h2 .accent { color: var(--teal); }
.cta-inner p  { font-size: 16px; color: rgba(255,255,255,0.45); margin-bottom: 36px; line-height: 1.65; }
.cta-actions { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }
.btn-cta-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--teal); color: var(--dark); font-size: 15px; font-weight: 700;
    padding: 14px 32px; border-radius: 8px; text-decoration: none; transition: background .12s, transform .12s;
}
.btn-cta-primary:hover { background: var(--teal-d); transform: translateY(-1px); }
.btn-cta-secondary { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 500; color: rgba(255,255,255,0.5); text-decoration: none; padding: 14px 20px; transition: color .12s; }
.btn-cta-secondary:hover { color: rgba(255,255,255,0.8); }

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media (max-width: 900px) {
    .features-grid     { grid-template-columns: repeat(2, 1fr); }
    .hiw-steps         { grid-template-columns: 1fr; gap: 40px; }
    .hiw-steps::before { display: none; }
    .tech-inner        { grid-template-columns: 1fr; gap: 40px; }
    .gam-cards         { grid-template-columns: 1fr; }
    .stats-strip-inner { grid-template-columns: repeat(2, 1fr); }
    .stat-item:nth-child(2) { border-right: none; }
    .stat-item:nth-child(3) { border-top: 1px solid var(--g200); border-right: 1px solid var(--g200); }
    .stat-item:nth-child(4) { border-top: 1px solid var(--g200); border-right: none; }
    .mockup-sidebar    { display: none; }
}
@media (max-width: 640px) {
    .hero, .features-section, .hiw-section, .tech-section, .gam-section, .cta-section { padding: 72px 20px; }
    .features-grid     { grid-template-columns: 1fr; }
    .section-header    { margin-bottom: 40px; }
    .hero h1           { letter-spacing: -1.5px; }
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-inner">
        <div class="hero-tag">
            <span class="tag-pill">Publisher Ad Infrastructure</span>
        </div>
        <h1>Ad management<br><span class="accent">built for publishers.</span></h1>
        <p class="hero-sub">
            Connect Google Ad Manager to your WordPress properties. Deploy ad units, manage publisher licenses, and optimise inventory — without the enterprise complexity.
        </p>
        <div class="hero-actions">
            @auth
            <a href="{{ route('dashboard') }}" class="btn-hero-primary">
                Go to Dashboard
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            @else
            <a href="{{ route('register') }}" class="btn-hero-primary">
                Get Started Free
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">Sign In</a>
            @endauth
        </div>

        {{-- Dashboard mockup --}}
        <div class="hero-mockup">
            <div class="mockup-bar">
                <div class="mockup-dot" style="background:#FF5F57;"></div>
                <div class="mockup-dot" style="background:#FEBC2E;"></div>
                <div class="mockup-dot" style="background:#28C840;"></div>
                <div class="mockup-url">app.percivo.io/dashboard</div>
            </div>
            <div class="mockup-body">
                <div class="mockup-sidebar">
                    <div class="mockup-brand"><div class="m-adiq">adIQ</div><span class="m-byp">by Percivo</span></div>
                    <div class="mockup-nav-item active"><div class="mockup-nav-dot"></div> Properties</div>
                    <div class="mockup-nav-item"><div class="mockup-nav-dot"></div> Console</div>
                </div>
                <div class="mockup-main">
                    <div class="mockup-topbar">Properties — Publisher Dashboard</div>
                    <div class="mockup-stats">
                        <div class="mockup-stat"><div class="mockup-stat-label">Total</div><div class="mockup-stat-val">4</div></div>
                        <div class="mockup-stat"><div class="mockup-stat-label">Licensed</div><div class="mockup-stat-val" style="color:#16A34A;">3</div></div>
                        <div class="mockup-stat"><div class="mockup-stat-label">GAM</div><div class="mockup-stat-val" style="color:#2DBDB5;">2</div></div>
                    </div>
                    <div class="mockup-table">
                        <div class="mockup-th">
                            <span>Domain</span><span>Access Key</span><span>License</span><span>GAM</span>
                        </div>
                        <div class="mockup-row">
                            <span>bestpublisher.com</span>
                            <span style="color:#9CA3AF;font-family:monospace;">a1b2c3d4…</span>
                            <span><span class="mockup-badge mb-green">Active</span></span>
                            <span><span class="mockup-badge mb-teal">Connected</span></span>
                        </div>
                        <div class="mockup-row">
                            <span>techreview.io</span>
                            <span style="color:#9CA3AF;font-family:monospace;">e5f6a1b2…</span>
                            <span><span class="mockup-badge mb-green">Active</span></span>
                            <span><span class="mockup-badge mb-gray">—</span></span>
                        </div>
                        <div class="mockup-row">
                            <span>staging.bestpublisher.com</span>
                            <span style="color:#9CA3AF;font-family:monospace;">c3d4e5f6…</span>
                            <span><span class="mockup-badge mb-gray">Inactive</span></span>
                            <span><span class="mockup-badge mb-gray">—</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS STRIP --}}
<div class="stats-strip">
    <div class="stats-strip-inner">
        <div class="stat-item">
            <div class="stat-num">0<span class="unit">ms</span></div>
            <div class="stat-desc">DB queries on page load</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">SHA<span class="unit">256</span></div>
            <div class="stat-desc">HMAC request signing</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">5<span class="unit">+</span></div>
            <div class="stat-desc">Approved origins per property</div>
        </div>
        <div class="stat-item">
            <div class="stat-num"><span class="unit">GPT</span></div>
            <div class="stat-desc">Native Google Publisher Tag</div>
        </div>
    </div>
</div>

{{-- CORE FEATURES --}}
<section class="features-section" id="features">
    <div class="container">
        <div class="section-header">
            <div class="tag-pill" style="margin-bottom:20px;">What adIQ does</div>
            <h2>Everything a publisher needs.<br>Nothing they don't.</h2>
            <p>Built specifically for WordPress publishers who want GAM-grade ad management without the enterprise overhead.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <h3>Google Ad Manager Integration</h3>
                <p>OAuth-powered one-click connection to your GAM network. Import ad units, sync sizes and targeting, and serve inventory without any hardcoded tags.</p>
                <span class="feature-tag">GAM · OAuth 2.0 · GPT</span>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </div>
                <h3>Multi-Property License Management</h3>
                <p>Issue and manage per-domain access keys across your entire property portfolio. Each key is cryptographically tied to its domain with subdomain whitelisting.</p>
                <span class="feature-tag">Domain-locked · Subdomain support</span>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <h3>CLS-Safe Lazy Loading</h3>
                <p>IntersectionObserver-based slot loading with reserved layout space. Ads only request the ad server as they approach the viewport — zero Cumulative Layout Shift.</p>
                <span class="feature-tag">CWV · CLS · IntersectionObserver</span>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Cryptographic API Security</h3>
                <p>Every plugin API call is signed with HMAC-SHA256 using the property's access key. Requests are domain-verified and replay-protected with a 5-minute window.</p>
                <span class="feature-tag">HMAC-SHA256 · Replay protection</span>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/>
                    </svg>
                </div>
                <h3>Key-Value Targeting</h3>
                <p>Automatically set GAM custom targeting on every pageview — page type, title, and category. Enables audience segmentation and price-floor targeting inside GAM.</p>
                <span class="feature-tag">GAM KV · Custom targeting</span>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <h3>In-Article Ad Injection</h3>
                <p>Automatically inject ad slots between paragraphs in post content. Configure position, paragraph offset, and minimum content length — no shortcodes required.</p>
                <span class="feature-tag">Auto-placement · Content filter</span>
            </div>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="hiw-section" id="how-it-works">
    <div class="hiw-inner">
        <div class="section-header">
            <div class="tag-pill" style="margin-bottom:20px;">Setup in minutes</div>
            <h2>From install to serving ads<br>in three steps.</h2>
            <p>No engineering resources, no ad ops specialist — just a WordPress plugin and your GAM credentials.</p>
        </div>
        <div class="hiw-steps">
            <div class="hiw-step">
                <div class="hiw-step-num">1</div>
                <h3>Install the Plugin</h3>
                <p>Download the adIQ plugin from your dashboard. Install on WordPress, enter your access key, and the property activates immediately.</p>
                <div class="step-detail">
                    <div class="dt-comment">// Activation handshake</div>
                    <div><span class="dt-key">POST</span> /api/v1/activate</div>
                    <div><span class="dt-key">license_key:</span> <span class="dt-val">a1b2c3…</span></div>
                    <div><span class="dt-key">site_url:</span> <span class="dt-val">yoursite.com</span></div>
                </div>
            </div>
            <div class="hiw-step">
                <div class="hiw-step-num">2</div>
                <h3>Connect GAM</h3>
                <p>Click "Connect Google Ad Manager" in the plugin. Complete the OAuth flow, select your network, and your ad units are ready to import.</p>
                <div class="step-detail">
                    <div class="dt-comment">// Token stored securely</div>
                    <div><span class="dt-key">network_id:</span> <span class="dt-val">21700000000</span></div>
                    <div><span class="dt-key">gam_email:</span> <span class="dt-val">adops@co.com</span></div>
                    <div><span class="dt-key">connected:</span> <span class="dt-val">true</span></div>
                </div>
            </div>
            <div class="hiw-step">
                <div class="hiw-step-num">3</div>
                <h3>Deploy Ad Units</h3>
                <p>Import units from GAM. Use shortcodes, in-article injection, or template tags to place them on your property. Ads go live instantly.</p>
                <div class="step-detail">
                    <div class="dt-comment">// Shortcode or auto-inject</div>
                    <div><span class="dt-key">[adiq</span> <span class="dt-val">id="leaderboard"</span><span class="dt-key">]</span></div>
                    <div>&nbsp;</div>
                    <div><span class="dt-key">paragraph:</span> <span class="dt-val">3</span> <span class="dt-comment">// in-article</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TECHNICAL DEEP DIVE --}}
<section class="tech-section" id="technical">
    <div class="tech-inner">
        <div class="tech-content">
            <div class="tag-pill" style="margin-bottom:20px;">Built for adtech teams</div>
            <h2>Engineered for performance<br>and security.</h2>
            <p>adIQ uses the same primitives that enterprise adtech platforms rely on — packaged for WordPress publishers.</p>
            <ul class="tech-list">
                <li><span><strong>Zero-query frontend:</strong> All ad config is served from a PHP file-based cache resident in OPcache — no database hit on any page load.</span></li>
                <li><span><strong>GPT native:</strong> Google Publisher Tag with <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">disableInitialLoad()</code>, per-slot <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">refresh()</code>, and configurable refresh intervals.</span></li>
                <li><span><strong>HMAC-SHA256 signed requests:</strong> Every plugin → API call is signed with the property access key. Domain whitelisting enforced at middleware with 5-minute replay protection.</span></li>
                <li><span><strong>GAM Key-Value targeting:</strong> <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">adiq_page_type</code>, <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">adiq_page_title</code>, <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">adiq_category</code> — set in <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">wp_head</code> before GPT fires.</span></li>
                <li><span><strong>Encrypted token storage:</strong> GAM OAuth tokens encrypted at rest using Laravel's built-in <code style="font-size:12px;background:var(--g100);padding:1px 5px;border-radius:3px;">encrypted</code> cast.</span></li>
                <li><span><strong>Device targeting:</strong> CSS media query + server-side per-unit targeting — Mobile only, Desktop only, or All devices.</span></li>
            </ul>
        </div>
        <div class="tech-code">
            <div class="code-header">
                <div class="code-dot" style="background:#FF5F57;"></div>
                <div class="code-dot" style="background:#FEBC2E;"></div>
                <div class="code-dot" style="background:#28C840;"></div>
                <span class="code-title">adiq-frontend.js</span>
            </div>
            <div class="code-body">
<span class="c-comment">// Reserve layout space, request ad on viewport entry</span>
<span class="c-fn">new</span> IntersectionObserver(<span class="c-fn">function</span>(entries) {
&nbsp;&nbsp;entries.<span class="c-fn">forEach</span>(entry => {
&nbsp;&nbsp;&nbsp;&nbsp;<span class="c-key">if</span> (!entry.isIntersecting) <span class="c-key">return</span>;
&nbsp;&nbsp;&nbsp;&nbsp;observer.<span class="c-fn">unobserve</span>(entry.target);

&nbsp;&nbsp;&nbsp;&nbsp;googletag.cmd.<span class="c-fn">push</span>(<span class="c-fn">function</span>() {
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;googletag.<span class="c-fn">display</span>(slotId);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;googletag.pubads().<span class="c-fn">refresh</span>([slot]);
&nbsp;&nbsp;&nbsp;&nbsp;});
&nbsp;&nbsp;});
}, { rootMargin: <span class="c-string">'200px'</span> });

<span class="c-comment">// KV targeting set before GPT fires</span>
googletag.pubads()
&nbsp;&nbsp;.<span class="c-fn">setTargeting</span>(<span class="c-string">'adiq_page_type'</span>, <span class="c-string">'article'</span>)
&nbsp;&nbsp;.<span class="c-fn">setTargeting</span>(<span class="c-string">'adiq_category'</span>, <span class="c-string">'technology'</span>);

<span class="c-comment">// Placeholder visible on no-fill (CLS-safe)</span>
googletag.pubads().<span class="c-fn">addEventListener</span>(
&nbsp;&nbsp;<span class="c-string">'slotRenderEnded'</span>, e => {
&nbsp;&nbsp;&nbsp;&nbsp;<span class="c-key">if</span> (!e.isEmpty) <span class="c-fn">log</span>(<span class="c-string">'Ad rendered ✓'</span>, e.size);
&nbsp;&nbsp;});
            </div>
        </div>
    </div>
</section>

{{-- GAM CARDS --}}
<section class="gam-section">
    <div class="gam-inner">
        <div class="section-header">
            <div class="tag-pill" style="margin-bottom:20px;">GAM Integration</div>
            <h2>Full Google Ad Manager support.<br>No API overhead.</h2>
            <p>adIQ proxies your GAM API through our platform — your WordPress plugin never holds OAuth credentials directly.</p>
        </div>
        <div class="gam-cards">
            <div class="gam-card">
                <div class="gam-card-icon">
                    <svg width="20" height="20" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                    </svg>
                </div>
                <h3>Ad Unit Import &amp; Sync</h3>
                <p>Fetch your full GAM ad unit hierarchy, select what you need, and import in one click. Sizes, targeting, and status sync back from GAM on demand.</p>
                <div class="chip-row">
                    <span class="chip">adUnits.list</span><span class="chip">adUnits.get</span><span class="chip">hierarchy</span>
                </div>
            </div>
            <div class="gam-card">
                <div class="gam-card-icon">
                    <svg width="20" height="20" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Secure OAuth Proxy</h3>
                <p>The OAuth flow runs through our platform. Access and refresh tokens are encrypted server-side — never exposed to the WordPress database or filesystem.</p>
                <div class="chip-row">
                    <span class="chip">OAuth 2.0</span><span class="chip">token refresh</span><span class="chip">encrypted at rest</span>
                </div>
            </div>
            <div class="gam-card">
                <div class="gam-card-icon">
                    <svg width="20" height="20" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                        <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                </div>
                <h3>One-Click KV Setup</h3>
                <p>Automatically provisions <code style="font-size:11px;background:var(--g100);padding:1px 5px;border-radius:3px;">adiq_page_type</code>, <code style="font-size:11px;background:var(--g100);padding:1px 5px;border-radius:3px;">adiq_page_title</code>, and <code style="font-size:11px;background:var(--g100);padding:1px 5px;border-radius:3px;">adiq_category</code> targeting keys directly in your GAM network — no manual setup.</p>
                <div class="chip-row">
                    <span class="chip">adiq_page_type</span><span class="chip">adiq_category</span><span class="chip">custom KV</span>
                </div>
            </div>
            <div class="gam-card">
                <div class="gam-card-icon">
                    <svg width="20" height="20" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3>Ad Refresh &amp; Viewability</h3>
                <p>Configurable slot-level refresh intervals using GPT's native refresh API. Throttled to stay within GAM policies and paired with IntersectionObserver viewability detection.</p>
                <div class="chip-row">
                    <span class="chip">pubads().refresh()</span><span class="chip">configurable TTL</span><span class="chip">viewability</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="cta-inner">
        <div class="tag-pill" style="margin-bottom:24px;">Start today</div>
        <h2>Your inventory.<br><span class="accent">Your control.</span></h2>
        <p>Get up and running in minutes. No engineering resources, no ad ops consultant — just a WordPress plugin and your GAM network.</p>
        <div class="cta-actions">
            @auth
            <a href="{{ route('dashboard') }}" class="btn-cta-primary">
                Go to Dashboard
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            @else
            <a href="{{ route('register') }}" class="btn-cta-primary">
                Get Started Free
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('login') }}" class="btn-cta-secondary">Already have an account? Sign in →</a>
            @endauth
        </div>
    </div>
</section>

@endsection
