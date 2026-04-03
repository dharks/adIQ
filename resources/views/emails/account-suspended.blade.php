<x-emails.layout subject="Your adIQ account has been suspended">
    <h1>Account suspended.</h1>

    <div class="danger-box">
        Your adIQ account has been suspended. Ad serving has been disabled for all properties on your account.
    </div>

    <p>If you believe this is an error or would like to appeal, contact us at <a href="mailto:{{ config('mail.from.address') }}" style="color:#2DBDB5;">{{ config('mail.from.address') }}</a> and include your account email address.</p>

    @if($adminNote)
    <div class="info-box">
        <strong>Reason:</strong> {{ $adminNote }}
    </div>
    @endif
</x-emails.layout>
