<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'adIQ by Percivo - Publisher Ad Management for WordPress'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta-description', 'Deploy and control any ad, across any network, from one place. Google Ad Manager, AdSense, and third-party networks unified for WordPress publishers.'); ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Percivo">
    <meta name="theme-color" content="#2DBDB5">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    
    <?php echo $__env->yieldPushContent('structured-data'); ?>

    
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/favicon.png')); ?>">

    
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="adIQ by Percivo">
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', 'adIQ by Percivo - Publisher Ad Management for WordPress'); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta-description', 'Deploy and control any ad, across any network, from one place. Google Ad Manager, AdSense, and third-party networks unified for WordPress publishers.'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image" content="<?php echo e(asset('images/adIQ-white-bg.png')); ?>">

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', 'adIQ by Percivo - Publisher Ad Management for WordPress'); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('meta-description', 'Deploy and control any ad, across any network, from one place. Google Ad Manager, AdSense, and third-party networks unified for WordPress publishers.'); ?>">
    <meta name="twitter:image" content="<?php echo e(asset('images/adIQ-white-bg.png')); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal: #2DBDB5;
            --teal-d: #1FA89F;
            --teal-l: rgba(45, 189, 181, 0.12);
            --dark: #0D1117;
            --dark-2: #161B27;
            --dark-3: #1C2333;
            --dark-bd: rgba(255, 255, 255, 0.08);
            --g50: #F8F9FB;
            --g100: #F1F3F5;
            --g200: #E2E5E9;
            --g400: #9CA3AF;
            --g500: #6B7280;
            --g700: #374151;
            --g900: #111827;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

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
            background: rgba(13, 17, 23, 0.92);
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
            align-items: center;
            text-decoration: none;
            line-height: 1;
        }

        .nav-brand img {
            height: 28px;
            width: auto;
            display: block;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 7px;
            transition: color .12s, background .12s;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

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

        .nav-cta:hover {
            background: var(--teal-d);
        }

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
            background: rgba(255, 255, 255, 0.7);
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

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .mobile-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
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
            color: rgba(255, 255, 255, 0.7);
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

        .footer-brand img {
            height: 30px;
            width: auto;
            display: block;
            margin-bottom: 14px;
        }

        .footer-percivo img {
            height: 20px;
            width: auto;
            opacity: 0.4;
            display: block;
            margin-top: 20px;
        }

        .footer-percivo span {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.25);
            display: block;
            margin-top: 5px;
        }

        .footer-brand p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.35);
            line-height: 1.65;
            max-width: 260px;
        }

        .footer-col h4 {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.35);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
        }

        .footer-col a {
            display: block;
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            margin-bottom: 10px;
            transition: color .12s;
        }

        .footer-col a:hover {
            color: #fff;
        }

        .footer-bottom {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 24px;
            border-top: 1px solid var(--dark-bd);
            font-size: 12px;
            color: rgba(255, 255, 255, 0.2);
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-bottom a {
            color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav-hamburger {
                display: flex;
            }

            .footer-inner {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .footer-col {
                display: none;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('head-styles'); ?>
</head>

<body>

    <!-- Nav -->
    <nav class="mkt-nav">
        <a href="<?php echo e(route('home')); ?>" class="nav-brand">
            <img src="<?php echo e(asset('images/adIQ-black-bg.png')); ?>" alt="adIQ by Percivo">
        </a>
        <div class="nav-links">
            <a href="#features" class="nav-link">Features</a>
            <a href="#how-it-works" class="nav-link">How it works</a>
            <a href="#technical" class="nav-link">Technical</a>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">Dashboard</a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="nav-link">Sign In</a>
            <a href="<?php echo e(route('register')); ?>" class="nav-cta">Get Started</a>
            <?php endif; ?>
        </div>
        <button class="nav-hamburger" onclick="document.getElementById('mobile-menu').classList.add('open')" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <a href="<?php echo e(route('home')); ?>" class="nav-brand" style="text-decoration:none;">
                <img src="<?php echo e(asset('images/adIQ-black-bg.png')); ?>" alt="adIQ by Percivo" style="height:26px;width:auto;">
            </a>
            <button class="mobile-close" onclick="document.getElementById('mobile-menu').classList.remove('open')">&times;</button>
        </div>
        <div class="mobile-nav-links">
            <a href="#features" class="mobile-nav-link" onclick="document.getElementById('mobile-menu').classList.remove('open')">Features</a>
            <a href="#how-it-works" class="mobile-nav-link" onclick="document.getElementById('mobile-menu').classList.remove('open')">How it works</a>
            <a href="#technical" class="mobile-nav-link" onclick="document.getElementById('mobile-menu').classList.remove('open')">Technical</a>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="mobile-nav-link">Dashboard</a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="mobile-nav-link">Sign In</a>
            <?php endif; ?>
        </div>
        <?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('register')); ?>" class="mobile-nav-cta">Get Started →</a>
        <?php endif; ?>
    </div>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="mkt-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="<?php echo e(asset('images/adIQ-black-bg.png')); ?>" alt="adIQ by Percivo">
                <p>Ad infrastructure for WordPress publishers. Deploy and control any ad, across any network, from one place.</p>
                <div class="footer-percivo">
                    <img src="<?php echo e(asset('images/percivo-black-bg.png')); ?>" alt="Percivo">
                    <span>A Percivo product</span>
                </div>
            </div>
            <div class="footer-col">
                <h4>Platform</h4>
                <a href="#features">Features</a>
                <a href="#how-it-works">How it works</a>
                <a href="#technical">Technical specs</a>
                <a href="<?php echo e(route('login')); ?>">Sign in</a>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="https://percivo.io" target="_blank" rel="noopener">Percivo</a>
                <a href="https://percivo.io/adIQ" target="_blank" rel="noopener">percivo.io/adIQ</a>
                <a href="https://adiq.percivo.io/login" target="_blank" rel="noopener">Publisher Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; <?php echo e(date('Y')); ?> Percivo. adIQ by Percivo. All rights reserved.</span>
            <div style="display:flex;gap:16px;align-items:center;">
                <a href="<?php echo e(route('privacy')); ?>">Privacy Policy</a>
                <a href="<?php echo e(route('terms')); ?>">Terms of Service</a>
                <a href="https://percivo.io" target="_blank" rel="noopener">percivo.io</a>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/layouts/marketing.blade.php ENDPATH**/ ?>