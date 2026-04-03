@extends('layouts.marketing')
@section('title', 'Privacy Policy - adIQ by Percivo')
@section('meta-description', 'Privacy Policy for adIQ by Percivo. Understand how we collect, use, and protect your data.')

@push('head-styles')
<style>
    .legal-wrap {
        max-width: 760px;
        margin: 0 auto;
        padding: 72px 24px 96px;
    }

    .legal-wrap h1 {
        font-size: 32px;
        font-weight: 800;
        color: var(--g900);
        letter-spacing: -0.8px;
        margin-bottom: 8px;
    }

    .legal-meta {
        font-size: 13px;
        color: var(--g400);
        margin-bottom: 48px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--g200);
    }

    .legal-wrap h2 {
        font-size: 17px;
        font-weight: 700;
        color: var(--g900);
        margin: 36px 0 10px;
    }

    .legal-wrap p,
    .legal-wrap li {
        font-size: 15px;
        color: var(--g700);
        line-height: 1.75;
        margin-bottom: 14px;
    }

    .legal-wrap ul {
        padding-left: 20px;
        margin-bottom: 14px;
    }

    .legal-wrap a {
        color: var(--teal);
        text-decoration: none;
    }

    .legal-wrap a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="legal-wrap">
    <h1>Privacy Policy</h1>
    <p class="legal-meta">Last updated: April 2025 &nbsp;·&nbsp; Percivo / adIQ by Percivo</p>

    <p>This Privacy Policy describes how Percivo ("we", "us", or "our") collects, uses, and protects information when you use adIQ by Percivo, including the adIQ WordPress plugin, the adIQ web platform at <a href="{{ route('home') }}">adiq.percivo.io</a>, and any related services (collectively, the "Service").</p>

    <h2>1. Information We Collect</h2>
    <p>We collect the following categories of information:</p>
    <ul>
        <li><strong>Account information:</strong> Name and email address provided when you register.</li>
        <li><strong>Site information:</strong> The domain URL of WordPress sites you register with adIQ.</li>
        <li><strong>Google account data (OAuth):</strong> When you connect Google Ad Manager via OAuth, we receive your Google account email address and the list of GAM networks associated with that account. We store an encrypted OAuth token to allow the plugin to communicate with GAM on your behalf.</li>
        <li><strong>Usage data:</strong> Standard server logs including IP addresses, request timestamps, and API call metadata. We do not log ad impression or revenue data.</li>
        <li><strong>Plugin API requests:</strong> The adIQ WordPress plugin communicates with our platform to validate licence keys and retrieve ad configuration. These requests include your site domain and a signed request token. No visitor personal data is transmitted.</li>
    </ul>

    <h2>2. How We Use Your Information</h2>
    <ul>
        <li>To authenticate your account and validate plugin licence keys.</li>
        <li>To connect to Google Ad Manager on your behalf and retrieve ad unit configuration.</li>
        <li>To deliver ad configuration to your WordPress site securely.</li>
        <li>To send transactional emails such as account confirmation (no marketing emails without consent).</li>
        <li>To maintain the security and integrity of the platform.</li>
    </ul>

    <h2>3. Google OAuth and GAM Data</h2>
    <p>adIQ uses Google OAuth 2.0 to connect to your Google Ad Manager account. The OAuth flow is handled via Google's secure authorisation servers. We request only the minimum scopes required to list your GAM networks and retrieve ad unit data.</p>
    <p>We store your OAuth refresh token in encrypted form on our servers. This token is used solely to serve requests initiated by your WordPress plugin. We do not share, sell, or use your Google account data for any purpose other than providing the adIQ service.</p>
    <p>You can revoke adIQ's access to your Google account at any time from your <a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener">Google Account permissions page</a>. Revoking access will disconnect GAM from your adIQ account.</p>

    <h2>4. Data Sharing</h2>
    <p>We do not sell, rent, or trade your personal information. We may share data with:</p>
    <ul>
        <li><strong>Infrastructure providers:</strong> Our hosting and database providers process data on our behalf under data processing agreements.</li>
        <li><strong>Google APIs:</strong> Data is passed to Google's APIs as necessary to fulfil the GAM integration.</li>
        <li><strong>Legal obligations:</strong> We may disclose information where required by law or to protect the rights and safety of Percivo and its users.</li>
    </ul>

    <h2>5. Data Retention</h2>
    <p>We retain your account data for as long as your account is active. You may request deletion of your account and associated data at any time by contacting us. OAuth tokens are deleted immediately when you disconnect GAM from your adIQ account.</p>

    <h2>6. Security</h2>
    <p>All communication between the adIQ WordPress plugin and our platform is signed with HMAC-SHA256 and transmitted over HTTPS. OAuth tokens are stored encrypted at rest. We apply industry-standard security practices to protect your data.</p>

    <h2>7. Cookies</h2>
    <p>The adIQ web platform uses session cookies strictly necessary for authentication. We do not use tracking or advertising cookies on this platform.</p>

    <h2>8. Your Rights</h2>
    <p>You have the right to access, correct, or delete the personal data we hold about you. To exercise these rights, contact us at <a href="mailto:privacy@percivo.io">privacy@percivo.io</a>.</p>

    <h2>9. Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time. Material changes will be communicated via the platform or by email. Continued use of the Service after changes constitutes acceptance of the updated policy.</p>

    <h2>10. Contact</h2>
    <p>For privacy-related questions, contact us at <a href="mailto:privacy@percivo.io">privacy@percivo.io</a> or visit <a href="https://percivo.io" target="_blank" rel="noopener">percivo.io</a>.</p>
</div>
@endsection