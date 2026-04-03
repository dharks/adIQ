<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'adIQ by Percivo' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #F1F3F5;
            color: #111827;
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrap {
            max-width: 580px;
            margin: 40px auto;
            padding: 0 16px 48px;
        }
        /* Header */
        .email-header {
            background: #0D1117;
            border-radius: 12px 12px 0 0;
            padding: 28px 36px;
            display: block;
        }
        .brand-logo img {
            height: 30px;
            width: auto;
            display: block;
        }
        .brand-name {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.4px;
            text-decoration: none;
        }
        .brand-sub {
            font-size: 10px;
            font-weight: 600;
            color: #2DBDB5;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            display: block;
            margin-top: 2px;
        }
        /* Body */
        .email-body {
            background: #ffffff;
            padding: 40px 36px;
        }
        .email-body h1 {
            font-size: 22px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.4px;
            margin-bottom: 12px;
        }
        .email-body p {
            color: #374151;
            margin-bottom: 16px;
            font-size: 15px;
            line-height: 1.65;
        }
        .email-body p:last-of-type { margin-bottom: 0; }
        /* CTA Button */
        .btn-primary {
            display: inline-block;
            background: #2DBDB5;
            color: #0D1117 !important;
            font-size: 15px;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 8px;
            text-decoration: none;
            margin: 24px 0;
        }
        /* Info box */
        .info-box {
            background: #F8F9FB;
            border: 1px solid #E2E5E9;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            font-size: 13.5px;
            color: #374151;
        }
        .info-box strong { color: #111827; }
        /* Warning box */
        .warning-box {
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            font-size: 13.5px;
            color: #92400E;
        }
        /* Danger box */
        .danger-box {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            font-size: 13.5px;
            color: #991B1B;
        }
        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #F1F3F5;
            margin: 24px 0;
        }
        /* Footer */
        .email-footer {
            background: #0D1117;
            border-radius: 0 0 12px 12px;
            padding: 24px 36px;
            text-align: center;
        }
        .email-footer p {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            margin-bottom: 6px;
        }
        .email-footer a {
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            font-size: 12px;
        }
        .email-footer a:hover { color: #2DBDB5; }
    </style>
</head>
<body>
<div class="email-wrap">

    <div class="email-header">
        <div class="brand-logo">
            <img src="{{ config('app.url') }}/images/adIQ-black-bg.png" alt="adIQ by Percivo" style="height:30px;width:auto;display:block;">
        </div>
    </div>

    <div class="email-body">
        {{ $slot }}
    </div>

    <div class="email-footer">
        <p>adIQ by Percivo &mdash; Ad infrastructure for WordPress publishers</p>
        <a href="{{ config('app.url') }}">{{ parse_url(config('app.url'), PHP_URL_HOST) }}</a>
        &nbsp;&middot;&nbsp;
        <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
        &nbsp;&middot;&nbsp;
        <a href="{{ config('app.url') }}/terms">Terms of Service</a>
    </div>

</div>
</body>
</html>
