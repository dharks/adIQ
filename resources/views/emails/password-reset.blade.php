<x-emails.layout subject="Reset your adIQ password">
    <h1>Reset your password.</h1>
    <p>We received a request to reset the password for your adIQ account. Click the button below to choose a new password.</p>

    <a href="{{ $resetUrl }}" class="btn-primary">Reset password &rarr;</a>

    <div class="info-box">
        This link expires in <strong>{{ $expiryMinutes }} minutes</strong>. If you did not request a password reset, no action is needed.
    </div>

    <p style="font-size:13px;color:#6B7280;">If the button above doesn't work, copy and paste this URL into your browser:<br>
    <a href="{{ $resetUrl }}" style="color:#2DBDB5;word-break:break-all;">{{ $resetUrl }}</a></p>
</x-emails.layout>
