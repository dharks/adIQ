<x-emails.layout subject="Welcome to adIQ by Percivo">
    <h1>Welcome to adIQ, {{ $name }}.</h1>
    <p>Your account has been created. You can now register your WordPress properties, connect Google Ad Manager, and start deploying ads from one place.</p>

    <a href="{{ $dashboardUrl }}" class="btn-primary">Go to your dashboard &rarr;</a>

    <hr class="divider">

    <p><strong>Getting started:</strong></p>
    <div class="info-box">
        <strong>1. Register a property</strong> &mdash; Add your WordPress site URL to your account.<br><br>
        <strong>2. Install the plugin</strong> &mdash; Download and activate the adIQ plugin on your WordPress site.<br><br>
        <strong>3. Activate your licence</strong> &mdash; Paste your licence key from the dashboard into the plugin settings.<br><br>
        <strong>4. Connect ad sources</strong> &mdash; Link Google Ad Manager or AdSense from the plugin.
    </div>

    <p style="font-size:13px;color:#6B7280;">If you didn't create this account, you can safely ignore this email.</p>
</x-emails.layout>
