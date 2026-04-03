<?php

namespace App\Mail;

use App\Models\GamToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GamTokenExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public GamToken $token) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'GAM disconnected - action required for ' . $this->token->site->domain);
    }

    public function content(): Content
    {
        $site = $this->token->site;
        return new Content(
            view: 'emails.gam-token-expired',
            with: [
                'domain'        => $site->domain ?: $site->url,
                'gamEmail'      => $this->token->email,
                'expiredAt'     => $this->token->expires_at->format('d M Y, H:i') . ' UTC',
                'siteDetailUrl' => route('sites.show', $site),
            ],
        );
    }
}
