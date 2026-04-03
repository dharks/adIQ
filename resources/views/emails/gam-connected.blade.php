<x-emails.layout subject="Google Ad Manager connected - {{ $domain }}">
    <h1>GAM connected successfully.</h1>
    <p>Google Ad Manager has been linked to your property <strong>{{ $domain }}</strong>.</p>

    <div class="info-box">
        <strong>Property:</strong> {{ $siteUrl }}<br>
        <strong>GAM Account:</strong> {{ $gamEmail }}<br>
        <strong>Network:</strong> {{ $networkName }}@if($networkId) &nbsp;<span style="color:#9CA3AF;">#{{ $networkId }}</span>@endif<br>
        <strong>Connected:</strong> {{ $connectedAt }}
    </div>

    <p>You can now import ad units from this GAM network and deploy them on your WordPress site via the adIQ plugin.</p>

    <a href="{{ $siteDetailUrl }}" class="btn-primary">View property &rarr;</a>

    <p style="font-size:13px;color:#6B7280;">If you did not authorise this connection, revoke access immediately from your <a href="https://myaccount.google.com/permissions" style="color:#2DBDB5;">Google Account permissions</a> and contact us.</p>
</x-emails.layout>