<?php

namespace App\Mail;

use App\Models\GamToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GamTokenExpiringMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public GamToken $token) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Action required: GAM connection expiring - ' . $this->token->site->domain);
    }

    public function content(): Content
    {
        $site = $this->token->site;
        return new Content(
            view: 'emails.gam-token-expiring',
            with: [
                'domain'          => $site->domain ?: $site->url,
                'gamEmail'        => $this->token->email,
                'expiresAt'       => $this->token->expires_at->format('d M Y, H:i') . ' UTC',
                'daysUntilExpiry' => (int) now()->diffInDays($this->token->expires_at, false),
                'siteDetailUrl'   => route('sites.show', $site),
            ],
        );
    }
}
