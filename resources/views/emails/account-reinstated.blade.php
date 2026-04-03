<x-emails.layout subject="Your adIQ account has been reinstated">
    <h1>Account reinstated.</h1>
    <p>Good news - your adIQ account has been reinstated. Ad serving has been restored for all active properties on your account.</p>

    <a href="{{ $dashboardUrl }}" class="btn-primary">Go to your dashboard &rarr;</a>

    <p style="font-size:13px;color:#6B7280;">If you have any questions, contact us at <a href="mailto:{{ config('mail.from.address') }}" style="color:#2DBDB5;">{{ config('mail.from.address') }}</a>.</p>
</x-emails.layout>