<?php

use App\Mail\GamTokenExpiredMail;
use App\Mail\GamTokenExpiringMail;
use App\Models\GamToken;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Daily: warn publishers whose GAM token expires within 7 days.
 * Daily: notify publishers whose GAM token has already expired.
 */
Schedule::call(function () {
    // Expiring soon (within 7 days, not yet expired)
    GamToken::with('site.user')
        ->where('expires_at', '>', now())
        ->where('expires_at', '<=', now()->addDays(7))
        ->get()
        ->each(function (GamToken $token) {
            Mail::to($token->site->user->email)
                ->send(new GamTokenExpiringMail($token));
        });

    // Already expired (notify once per day until reconnected)
    GamToken::with('site.user')
        ->where('expires_at', '<=', now())
        ->get()
        ->each(function (GamToken $token) {
            Mail::to($token->site->user->email)
                ->queue(new GamTokenExpiredMail($token));
        });
})->dailyAt('08:00')->name('gam-token-expiry-check')->withoutOverlapping();
