<x-emails.layout subject="GAM disconnected - action required for {{ $domain }}">
    <h1>Your GAM connection has expired.</h1>

    <div class="danger-box">
        <strong>Property:</strong> {{ $domain }}<br>
        <strong>GAM Account:</strong> {{ $gamEmail }}<br>
        <strong>Expired:</strong> {{ $expiredAt }}
    </div>

    <p>The Google Ad Manager connection for <strong>{{ $domain }}</strong> has expired. GAM ad units are no longer serving on this property.</p>

    <p>To restore service, go to <strong>adIQ &rarr; Settings</strong> in your WordPress admin and click <strong>Reconnect GAM</strong>.</p>

    <a href="{{ $siteDetailUrl }}" class="btn-primary">View property &rarr;</a>
</x-emails.layout>