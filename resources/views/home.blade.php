@extends('layouts.marketing')
@section('title', 'adIQ by Percivo — Ad Infrastructure for WordPress Publishers')
@section('meta-description', 'Deploy and control any ad, across any network, from one place. Google Ad Manager, AdSense, and third-party networks unified under a single platform built for serious publishers.')

@push('head-styles')
<style>
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .tag-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(45, 189, 181, 0.1);
        border: 1px solid rgba(45, 189, 181, 0.25);
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
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--teal);
        flex-shrink: 0;
    }

    /* ── Hero ── */
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
            linear-gradient(rgba(45, 189, 181, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(45, 189, 181, 0.04) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    .hero::after {
        content: '';
        position: absolute;
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        width: 700px;
        height: 700px;
        background: radial-gradient(circle, rgba(45, 189, 181, 0.12) 0%, transparent 65%);
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero h1 {
        font-size: clamp(38px, 6vw, 68px);
        font-weight: 900;
        color: #fff;
        letter-spacing: -2px;
        line-height: 1.08;
        margin: 20px 0 22px;
    }

    .hero h1 em {
        font-style: normal;
        color: var(--teal);
    }

    .hero-sub {
        font-size: clamp(15px, 2vw, 18px);
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.7;
        max-width: 580px;
        margin: 0 auto 36px;
    }

    .hero-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
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
        transition: background .12s, transform .1s;
    }

    .btn-hero-primary:hover {
        background: var(--teal-d);
        transform: translateY(-1px);
    }

    .btn-hero-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.75);
        font-size: 15px;
        font-weight: 600;
        padding: 14px 28px;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: background .12s;
    }

    .btn-hero-ghost:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    /* ── Proof strip ── */
    .proof-strip {
        background: var(--dark-2);
        border-top: 1px solid var(--dark-bd);
        border-bottom: 1px solid var(--dark-bd);
        padding: 20px 24px;
    }

    .proof-strip-inner {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 48px;
        flex-wrap: wrap;
    }

    .proof-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.45);
        font-size: 13px;
        font-weight: 500;
    }

    .proof-item strong {
        color: #fff;
        font-weight: 700;
        font-size: 15px;
    }

    .proof-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--dark-bd);
        flex-shrink: 0;
    }

    /* ── Section base ── */
    section {
        padding: 96px 24px;
    }

    section.dark {
        background: var(--dark);
    }

    section.dark-2 {
        background: var(--dark-2);
    }

    section.light {
        background: #fff;
    }

    section.gray {
        background: var(--g50);
    }

    .section-tag {
        margin-bottom: 16px;
    }

    .section-heading {
        font-size: clamp(26px, 4vw, 40px);
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.15;
        margin-bottom: 16px;
    }

    .section-heading.light-text {
        color: #fff;
    }

    .section-heading.dark-text {
        color: var(--g900);
    }

    .section-sub {
        font-size: 16px;
        line-height: 1.7;
        max-width: 560px;
    }

    .section-sub.light-text {
        color: rgba(255, 255, 255, 0.5);
    }

    .section-sub.dark-text {
        color: var(--g500);
    }

    /* ── Networks ── */
    .networks-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 56px;
    }

    .network-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 28px;
        transition: border-color .15s;
    }

    .network-card:hover {
        border-color: rgba(45, 189, 181, 0.35);
    }

    .network-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 20px;
    }

    .network-icon.gam {
        background: rgba(66, 133, 244, 0.15);
    }

    .network-icon.adsense {
        background: rgba(52, 168, 83, 0.15);
    }

    .network-icon.third {
        background: rgba(45, 189, 181, 0.12);
    }

    .network-card h3 {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
    }

    .network-card p {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.45);
        line-height: 1.65;
        margin-bottom: 16px;
    }

    .network-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .ntag {
        font-size: 11px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* ── Control section ── */
    .control-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: center;
        margin-top: 0;
    }

    .control-points {
        display: flex;
        flex-direction: column;
        gap: 28px;
        margin-top: 36px;
    }

    .control-point {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .cp-icon {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        background: rgba(45, 189, 181, 0.12);
        border: 1px solid rgba(45, 189, 181, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cp-text h4 {
        font-size: 15px;
        font-weight: 600;
        color: var(--g900);
        margin-bottom: 4px;
    }

    .cp-text p {
        font-size: 13.5px;
        color: var(--g500);
        line-height: 1.6;
    }

    .control-visual {
        background: var(--dark);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
    }

    .cv-header {
        background: rgba(255, 255, 255, 0.04);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cv-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .cv-body {
        padding: 20px;
    }

    .ad-unit-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.03);
        margin-bottom: 8px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 12.5px;
    }

    .au-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .au-name {
        color: rgba(255, 255, 255, 0.75);
        font-weight: 500;
    }

    .au-network {
        font-size: 10.5px;
        padding: 2px 7px;
        border-radius: 4px;
        font-weight: 600;
    }

    .au-network.gam {
        background: rgba(66, 133, 244, 0.15);
        color: #4285f4;
    }

    .au-network.adsense {
        background: rgba(52, 168, 83, 0.15);
        color: #34a853;
    }

    .au-network.third {
        background: rgba(45, 189, 181, 0.12);
        color: var(--teal);
    }

    .au-status {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #34a853;
    }

    /* ── Features grid ── */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 56px;
    }

    .feature-card {
        background: #fff;
        border: 1px solid var(--g200);
        border-radius: 12px;
        padding: 28px;
        transition: box-shadow .15s, border-color .15s;
    }

    .feature-card:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
        border-color: rgba(45, 189, 181, 0.35);
    }

    .feat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(45, 189, 181, 0.08);
        border: 1px solid rgba(45, 189, 181, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .feature-card h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--g900);
        margin-bottom: 8px;
    }

    .feature-card p {
        font-size: 13.5px;
        color: var(--g500);
        line-height: 1.65;
    }

    /* ── Steps ── */
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        margin-top: 56px;
        position: relative;
    }

    .steps-grid::before {
        content: '';
        position: absolute;
        top: 28px;
        left: calc(16.6% + 20px);
        right: calc(16.6% + 20px);
        height: 1px;
        background: linear-gradient(90deg, var(--g200), var(--g200));
        z-index: 0;
    }

    .step-card {
        padding: 0 24px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .step-num {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--dark);
        color: var(--teal);
        font-size: 18px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border: 2px solid rgba(45, 189, 181, 0.35);
        position: relative;
    }

    .step-card h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--g900);
        margin-bottom: 10px;
    }

    .step-card p {
        font-size: 13.5px;
        color: var(--g500);
        line-height: 1.65;
    }

    /* ── Performance grid ── */
    .perf-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2px;
        margin-top: 56px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
    }

    .perf-cell {
        background: rgba(255, 255, 255, 0.02);
        padding: 32px 28px;
        transition: background .15s;
    }

    .perf-cell:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .perf-num {
        font-size: 36px;
        font-weight: 900;
        color: var(--teal);
        letter-spacing: -1px;
        line-height: 1;
        margin-bottom: 8px;
    }

    .perf-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 6px;
    }

    .perf-desc {
        font-size: 12.5px;
        color: rgba(255, 255, 255, 0.4);
        line-height: 1.55;
    }

    /* ── Percivo band ── */
    .percivo-band {
        background: var(--dark-3);
        border-top: 1px solid var(--dark-bd);
        border-bottom: 1px solid var(--dark-bd);
        padding: 40px 24px;
        text-align: center;
    }

    .percivo-band img {
        height: 32px;
        opacity: 0.55;
        filter: brightness(2);
    }

    .percivo-band p {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.3);
        margin-top: 12px;
    }

    /* ── CTA ── */
    .cta-section {
        background: var(--dark);
        padding: 96px 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        bottom: -100px;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(45, 189, 181, 0.1) 0%, transparent 65%);
        pointer-events: none;
    }

    .cta-section h2 {
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 900;
        color: #fff;
        letter-spacing: -1.5px;
        margin-bottom: 16px;
        position: relative;
    }

    .cta-section p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.45);
        max-width: 480px;
        margin: 0 auto 36px;
        line-height: 1.65;
        position: relative;
    }

    .cta-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {

        .networks-grid,
        .features-grid {
            grid-template-columns: 1fr 1fr;
        }

        .perf-grid {
            grid-template-columns: 1fr 1fr;
        }

        .control-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .control-visual {
            display: none;
        }
    }

    @media (max-width: 640px) {

        .networks-grid,
        .features-grid,
        .perf-grid {
            grid-template-columns: 1fr;
        }

        .steps-grid {
            grid-template-columns: 1fr;
            gap: 32px;
        }

        .steps-grid::before {
            display: none;
        }

        .proof-strip-inner {
            gap: 24px;
        }

        .proof-dot {
            display: none;
        }

        section {
            padding: 64px 24px;
        }
    }
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<section class="hero">
    <div class="hero-inner">
        <div class="tag-pill">Ad Infrastructure for Publishers</div>
        <h1>Deploy any ad.<br><em>From one place.</em></h1>
        <p class="hero-sub">
            Google Ad Manager, AdSense, and third-party networks unified under one platform.
            Configure once, deploy everywhere, control everything.
        </p>
        <div class="hero-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                Get Started Free
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
            <a href="#how-it-works" class="btn-hero-ghost">
                See how it works
            </a>
        </div>
    </div>
</section>

{{-- ── Proof strip ── --}}
<div class="proof-strip">
    <div class="proof-strip-inner">
        <div class="proof-item">
            <strong>0ms</strong> DB queries on page load
        </div>
        <div class="proof-dot"></div>
        <div class="proof-item">
            <strong>3</strong> ad networks supported
        </div>
        <div class="proof-dot"></div>
        <div class="proof-item">
            <strong>SHA-256</strong> signed API requests
        </div>
        <div class="proof-dot"></div>
        <div class="proof-item">
            <strong>1</strong> shortcode. Any placement.
        </div>
        <div class="proof-dot"></div>
        <div class="proof-item">
            <strong>5-minute</strong> file cache, zero latency
        </div>
    </div>
</div>

{{-- ── Networks ── --}}
<section class="dark" id="features">
    <div class="container">
        <div class="section-tag"><span class="tag-pill">Multi-Network</span></div>
        <h2 class="section-heading light-text">Every major ad network.<br>One unified control layer.</h2>
        <p class="section-sub light-text">
            Stop managing networks in isolation. adIQ connects all your revenue sources into a single deployment and configuration system.
        </p>

        <div class="networks-grid">
            <div class="network-card">
                <div class="network-icon gam">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="#4285f4">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" />
                    </svg>
                </div>
                <h3>Google Ad Manager</h3>
                <p>Full OAuth integration with your GAM network. Import ad units, sync inventory, and deploy programmatic ads with key-value targeting at the page level.</p>
                <div class="network-tags">
                    <span class="ntag">OAuth 2.0</span>
                    <span class="ntag">Ad unit import</span>
                    <span class="ntag">KV targeting</span>
                    <span class="ntag">Network sync</span>
                </div>
            </div>

            <div class="network-card">
                <div class="network-icon adsense">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="#34a853">
                        <path d="M21.35 11.1h-9.17v2.73h6.51c-.33 3.81-3.5 5.44-6.5 5.44C8.36 19.27 5 16.25 5 12c0-4.1 3.2-7.27 7.2-7.27 3.09 0 4.9 1.97 4.9 1.97L19 4.72S16.56 2 12.1 2C6.42 2 2.03 6.8 2.03 12c0 5.05 4.13 10 10.22 10 5.35 0 9.25-3.67 9.25-9.09 0-1.15-.15-1.81-.15-1.81z" />
                    </svg>
                </div>
                <h3>Google AdSense</h3>
                <p>Connect AdSense placements directly to your WordPress pages. Manage ad code centrally and deploy across the site without touching individual templates.</p>
                <div class="network-tags">
                    <span class="ntag">Centralised code</span>
                    <span class="ntag">Auto placement</span>
                    <span class="ntag">Page targeting</span>
                    <span class="ntag">Fill fallback</span>
                </div>
            </div>

            <div class="network-card">
                <div class="network-icon third">
                    <svg width="22" height="22" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                </div>
                <h3>Third-Party Networks</h3>
                <p>Inject any ad tag from any network into defined placements. Paste the script once and adIQ handles rendering, lazy loading, and lifecycle management automatically.</p>
                <div class="network-tags">
                    <span class="ntag">Any ad tag</span>
                    <span class="ntag">Script injection</span>
                    <span class="ntag">Lazy render</span>
                    <span class="ntag">Lifecycle hooks</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Control section ── --}}
<section class="light">
    <div class="container">
        <div class="control-grid">
            <div>
                <div class="section-tag"><span class="tag-pill">Control</span></div>
                <h2 class="section-heading dark-text">Centralised. Consistent.<br>In your hands.</h2>
                <p class="section-sub dark-text">
                    Ad placements that are consistent across every page, every network, every device. No manual insertion. No template edits. No surprises.
                </p>
                <div class="control-points">
                    <div class="control-point">
                        <div class="cp-icon">
                            <svg width="16" height="16" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
                            </svg>
                        </div>
                        <div class="cp-text">
                            <h4>Centralised ad control</h4>
                            <p>All placements, all networks, all pages managed from one settings panel. Change a placement once and it updates everywhere instantly.</p>
                        </div>
                    </div>
                    <div class="control-point">
                        <div class="cp-icon">
                            <svg width="16" height="16" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                        </div>
                        <div class="cp-text">
                            <h4>Consistent placements across pages</h4>
                            <p>Header, in-article, sidebar, and footer placements maintain identical behaviour on every page type — posts, archives, and custom templates.</p>
                        </div>
                    </div>
                    <div class="control-point">
                        <div class="cp-icon">
                            <svg width="16" height="16" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="cp-text">
                            <h4>Unified deployment</h4>
                            <p>One shortcode. Any ad unit from any connected network. Rendered with the right script, in the right container, with CLS prevention built in.</p>
                        </div>
                    </div>
                    <div class="control-point">
                        <div class="cp-icon">
                            <svg width="16" height="16" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div class="cp-text">
                            <h4>Speed by design</h4>
                            <p>File-based cache and zero database queries on the front end. Lazy loading and on-demand rendering keep page scores intact regardless of ad count.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="control-visual">
                <div class="cv-header">
                    <div class="cv-dot" style="background:#ff5f57;"></div>
                    <div class="cv-dot" style="background:#febc2e;"></div>
                    <div class="cv-dot" style="background:#28c840;"></div>
                    <span style="font-size:12px;color:rgba(255,255,255,0.3);margin-left:10px;">Ad Units — my-site.com</span>
                </div>
                <div class="cv-body">
                    <div style="font-size:11px;color:rgba(255,255,255,0.25);margin-bottom:12px;text-transform:uppercase;letter-spacing:0.06em;">Active placements</div>

                    <div class="ad-unit-row">
                        <div class="au-left">
                            <div class="au-status"></div>
                            <span class="au-name">header_leaderboard</span>
                            <span class="au-network gam">GAM</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.25);">728×90</span>
                    </div>
                    <div class="ad-unit-row">
                        <div class="au-left">
                            <div class="au-status"></div>
                            <span class="au-name">article_mpu_top</span>
                            <span class="au-network adsense">AdSense</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.25);">300×250</span>
                    </div>
                    <div class="ad-unit-row">
                        <div class="au-left">
                            <div class="au-status"></div>
                            <span class="au-name">in_article_2</span>
                            <span class="au-network third">Custom</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.25);">fluid</span>
                    </div>
                    <div class="ad-unit-row">
                        <div class="au-left">
                            <div class="au-status"></div>
                            <span class="au-name">sidebar_halfpage</span>
                            <span class="au-network gam">GAM</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.25);">300×600</span>
                    </div>
                    <div class="ad-unit-row">
                        <div class="au-left">
                            <div class="au-status"></div>
                            <span class="au-name">footer_banner</span>
                            <span class="au-network adsense">AdSense</span>
                        </div>
                        <span style="font-size:11px;color:rgba(255,255,255,0.25);">970×90</span>
                    </div>

                    <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.06);display:flex;gap:8px;">
                        <div style="flex:1;background:rgba(45,189,181,0.08);border:1px solid rgba(45,189,181,0.15);border-radius:7px;padding:12px;text-align:center;">
                            <div style="font-size:18px;font-weight:800;color:var(--teal);">5</div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:3px;">Active</div>
                        </div>
                        <div style="flex:1;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:7px;padding:12px;text-align:center;">
                            <div style="font-size:18px;font-weight:800;color:rgba(255,255,255,0.6);">3</div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:3px;">Networks</div>
                        </div>
                        <div style="flex:1;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:7px;padding:12px;text-align:center;">
                            <div style="font-size:18px;font-weight:800;color:rgba(255,255,255,0.6);">0ms</div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:3px;">DB queries</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Features grid ── --}}
<section class="gray">
    <div class="container">
        <div class="section-tag"><span class="tag-pill">Capabilities</span></div>
        <h2 class="section-heading dark-text">Publisher-grade features,<br>without the enterprise contract.</h2>
        <p class="section-sub dark-text">
            Every capability a serious publisher needs, built into one coherent system from day one.
        </p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </div>
                <h3>Lazy and On-Demand Loading</h3>
                <p>Ads render only when entering the viewport via IntersectionObserver. On-demand loading triggers specific units without page reload, protecting Core Web Vitals scores.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" />
                    </svg>
                </div>
                <h3>Dynamic In-Article Injection</h3>
                <p>Automatically injects ad units between paragraphs at configurable intervals. No shortcodes needed in post content. Works across all post types and page templates.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <h3>Key-Value Targeting</h3>
                <p>Automatically attaches page-level key-values to every GAM ad request. Page type, category, and title are passed as targeting parameters, enabling precise audience segments.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="5" y="2" width="14" height="20" rx="2" />
                        <path d="M12 18h.01" />
                    </svg>
                </div>
                <h3>Device Targeting</h3>
                <p>Serve different ad units to desktop and mobile visitors from the same placement configuration. Responsive breakpoints handled in the platform, not in post templates.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <h3>HMAC-Signed Security</h3>
                <p>Every API call between WordPress and the adIQ platform is signed with SHA-256 HMAC with 5-minute replay protection. Domain whitelist enforcement prevents licence abuse.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="1 4 1 10 7 10" />
                        <path d="M3.51 15a9 9 0 102.13-9.36L1 10" />
                    </svg>
                </div>
                <h3>Viewability Refresh</h3>
                <p>Units that remain in-view beyond a configurable threshold can be automatically refreshed to improve fill rates. Refresh intervals and eligibility rules are fully configurable.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M9 9h6M9 12h6M9 15h4" />
                    </svg>
                </div>
                <h3>CLS Prevention</h3>
                <p>Ad containers reserve their space before the creative loads, eliminating Cumulative Layout Shift. No-fill events leave a contained placeholder rather than collapsing the page layout.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" />
                    </svg>
                </div>
                <h3>Export and Restore</h3>
                <p>Full configuration export to JSON. Restore placements, network settings, and targeting rules across staging and production environments with a single file upload.</p>
            </div>

            <div class="feature-card">
                <div class="feat-icon">
                    <svg width="18" height="18" fill="none" stroke="var(--teal)" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14" />
                    </svg>
                </div>
                <h3>Per-Property Licensing</h3>
                <p>Each WordPress site registers independently with a unique HMAC key. Approved origins extend access to staging subdomains without compromising production security.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── How it works ── --}}
<section class="light" id="how-it-works">
    <div class="container" style="text-align:center;">
        <div class="section-tag" style="display:inline-flex;"><span class="tag-pill">How It Works</span></div>
        <h2 class="section-heading dark-text" style="margin-top:16px;">Three steps from setup to live.</h2>
        <p class="section-sub dark-text" style="margin:0 auto 0;">
            adIQ is designed to go from installation to live ads in under an hour.
        </p>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <h3>Connect ad sources</h3>
                <p>Authorise Google Ad Manager via OAuth, configure AdSense, or paste tags from any third-party network. adIQ handles token storage and credential management.</p>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <h3>Configure placements</h3>
                <p>Define header, in-article, sidebar, and footer placements. Set targeting rules, lazy load thresholds, device breakpoints, and refresh conditions per unit.</p>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <h3>Deploy across the site</h3>
                <p>Activate and every page on your WordPress site immediately serves the correct ad to the correct placement, across all networks, with zero further configuration.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── Performance ── --}}
<section class="dark" id="technical">
    <div class="container">
        <div class="section-tag"><span class="tag-pill">Performance</span></div>
        <h2 class="section-heading light-text">Built so it never slows you down.</h2>
        <p class="section-sub light-text">
            Every architectural decision in adIQ was made with publisher page performance as a constraint, not an afterthought.
        </p>

        <div class="perf-grid">
            <div class="perf-cell">
                <div class="perf-num">0</div>
                <div class="perf-label">Database queries on front end</div>
                <div class="perf-desc">All ad configuration is served from a file-based cache in wp-content. No MySQL on every page load.</div>
            </div>
            <div class="perf-cell">
                <div class="perf-num">5m</div>
                <div class="perf-label">Cache TTL, auto-invalidated</div>
                <div class="perf-desc">Settings changes propagate within 5 minutes automatically. Manual flush available from the admin panel.</div>
            </div>
            <div class="perf-cell">
                <div class="perf-num">GPT</div>
                <div class="perf-label">Google Publisher Tag native</div>
                <div class="perf-desc">Uses GPT's disableInitialLoad and refresh APIs for precise ad lifecycle control. slotRenderEnded handled natively.</div>
            </div>
            <div class="perf-cell">
                <div class="perf-num">CLS</div>
                <div class="perf-label">Zero layout shift on load</div>
                <div class="perf-desc">Containers reserve their space before creative loads. No-fill events leave a contained placeholder, not a collapse.</div>
            </div>
            <div class="perf-cell">
                <div class="perf-num">SHA</div>
                <div class="perf-label">256-bit signed API calls</div>
                <div class="perf-desc">HMAC-SHA256 with 5-minute replay protection on every request between WordPress and the adIQ platform.</div>
            </div>
            <div class="perf-cell">
                <div class="perf-num">IO</div>
                <div class="perf-label">IntersectionObserver lazy render</div>
                <div class="perf-desc">Ads outside the viewport do not load. IntersectionObserver fires render when the unit is about to enter view, preserving LCP scores.</div>
            </div>
        </div>
    </div>
</section>

{{-- ── Percivo brand band ── --}}
<div class="percivo-band">
    <img src="{{ asset('images/percivo-black-bg.png') }}" alt="Percivo" style="height:28px;width:auto;opacity:0.7;">
    <p>adIQ is a product of Percivo. Publisher technology built for serious operators.</p>
</div>

{{-- ── CTA ── --}}
<section class="cta-section">
    <div style="position:relative;z-index:1;">
        <div class="section-tag" style="display:inline-flex;margin-bottom:20px;"><span class="tag-pill">Get Started</span></div>
        <h2>Your inventory. Your control.</h2>
        <p>Ad infrastructure for publishers who want consistency, speed, and full control over every placement, across every network.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                Create a free account
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
            <a href="https://percivo.io/adIQ" target="_blank" rel="noopener" class="btn-hero-ghost">
                Learn more at percivo.io
            </a>
        </div>
    </div>
</section>

@endsection