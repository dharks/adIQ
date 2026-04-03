<x-emails.layout subject="Action required: GAM connection expiring - {{ $domain }}">
    <h1>Your GAM connection is expiring soon.</h1>

    <div class="warning-box">
        <strong>Property:</strong> {{ $domain }}<br>
        <strong>GAM Account:</strong> {{ $gamEmail }}<br>
        <strong>Expires:</strong> {{ $expiresAt }}
    </div>

    <p>Your Google Ad Manager OAuth token for <strong>{{ $domain }}</strong> will expire in <strong>{{ $daysUntilExpiry }} day(s)</strong>. After expiry, GAM ad units will stop serving on this property.</p>

    <p>To reconnect, open your WordPress admin, go to <strong>adIQ &rarr; Settings</strong>, and click <strong>Reconnect GAM</strong>. This takes less than a minute.</p>

    <a href="{{ $siteDetailUrl }}" class="btn-primary">View property &rarr;</a>

    <p style="font-size:13px;color:#6B7280;">If you no longer use GAM on this property you can disconnect it from your dashboard.</p>
</x-emails.layout>