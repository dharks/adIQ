<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Sign In'); ?> - adIQ by Percivo</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal: #2DBDB5;
            --teal-d: #1FA89F;
            --dark: #0D1117;
            --dark-2: #161B27;
            --g50: #F8F9FB;
            --g100: #F1F3F5;
            --g200: #E2E5E9;
            --g400: #9CA3AF;
            --g500: #6B7280;
            --g700: #374151;
            --g900: #111827;
            --red: #DC2626;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            display: flex;
            min-height: 100vh;
            color: var(--g900);
            background: var(--dark);
        }

        /* ── Left panel ── */
        .auth-left {
            width: 420px;
            flex-shrink: 0;
            background: var(--dark);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -120px;
            left: -120px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(45, 189, 181, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(45, 189, 181, 0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-brand {
            position: relative;
            z-index: 1;
        }

        .auth-brand-logo {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-bottom: 48px;
        }

        .auth-brand-logo img {
            height: 32px;
            width: auto;
            display: block;
            align-self: flex-start;
            object-fit: contain;
        }

        .auth-brand h2 {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 14px;
        }

        .auth-brand p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.65;
        }

        .auth-features {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .auth-feature {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .auth-feature-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--teal);
            flex-shrink: 0;
            margin-top: 5px;
        }

        .auth-feature-text {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.5;
        }

        .auth-footer-note {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }

        /* ── Right panel ── */
        .auth-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 400px;
        }

        .auth-form-wrap h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--g900);
            margin-bottom: 6px;
        }

        .auth-form-wrap .auth-sub {
            font-size: 14px;
            color: var(--g500);
            margin-bottom: 32px;
        }

        /* Alert */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-error {
            background: #FEF2F2;
            color: var(--red);
            border: 1px solid #FECACA;
        }

        .alert-success {
            background: #F0FDF4;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--g700);
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--g200);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--g900);
            transition: border-color .15s, box-shadow .15s;
            background: var(--g50);
        }

        .form-group input:focus {
            border-color: var(--teal);
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 189, 181, .12);
            background: #fff;
        }

        .form-err {
            font-size: 12px;
            color: var(--red);
            margin-top: 4px;
        }

        /* Checkbox row */
        .check-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .check-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 1.5px solid var(--g200);
            border-radius: 4px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .check-row label {
            font-size: 13px;
            color: var(--g500);
            cursor: pointer;
        }

        /* Button */
        .btn-auth {
            width: 100%;
            padding: 12px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background .15s;
            letter-spacing: 0.01em;
        }

        .btn-auth:hover {
            background: var(--teal-d);
        }

        .auth-switch {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--g500);
        }

        .auth-switch a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 40px 24px;
                background: var(--g50);
            }

            .auth-form-wrap {
                background: #fff;
                border: 1px solid var(--g200);
                border-radius: 12px;
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-left">
        <div class="auth-brand">
            <div class="auth-brand-logo">
                <img src="<?php echo e(asset('images/adIQ-black-bg.png')); ?>" alt="adIQ by Percivo">
            </div>
            <h2>One platform. Every ad network. Full control.</h2>
            <p>Run Google Ad Manager, AdSense, and third-party networks side by side - with per-property licensing, domain security, and smart ad delivery built in.</p>
        </div>
        <div class="auth-features">
            <div class="auth-feature">
                <div class="auth-feature-dot"></div>
                <div class="auth-feature-text">GAM, AdSense and third-party networks from a single dashboard</div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-dot"></div>
                <div class="auth-feature-text">Per-property license keys with domain whitelist enforcement</div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-dot"></div>
                <div class="auth-feature-text">Cryptographically signed API - HMAC-SHA256 request verification</div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-dot"></div>
                <div class="auth-feature-text">CLS-safe lazy loading with device targeting and viewability refresh</div>
            </div>
        </div>
        <div class="auth-footer-note">&copy; <?php echo e(date('Y')); ?> Percivo. adIQ by Percivo.</div>
    </div>

    <div class="auth-right">
        <div class="auth-form-wrap">
            <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($err); ?><br><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            <?php if(session('flash')): ?>
            <div class="alert alert-success"><?php echo e(session('flash')); ?></div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</body>

</html><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/layouts/auth.blade.php ENDPATH**/ ?>