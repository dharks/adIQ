<x-emails.layout subject="Licence activated - {{ $domain }}">
    <h1>Licence activated.</h1>
    <p>Your adIQ licence has been successfully activated on <strong>{{ $domain }}</strong>.</p>

    <div class="info-box">
        <strong>Property:</strong> {{ $siteUrl }}<br>
        <strong>Domain:</strong> {{ $domain }}<br>
        <strong>Activated:</strong> {{ $activatedAt }}
    </div>

    <p>Ads will now be served on this domain. If you need to allow staging or subdomain access, add approved origins from your dashboard.</p>

    <a href="{{ $siteDetailUrl }}" class="btn-primary">View property &rarr;</a>

    <p style="font-size:13px;color:#6B7280;">If you did not activate this licence, contact us immediately at <a href="mailto:{{ config('mail.from.address') }}" style="color:#2DBDB5;">{{ config('mail.from.address') }}</a>.</p>
</x-emails.layout>