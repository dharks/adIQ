<?php

namespace App\Mail;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountSuspendedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Site $site) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your adIQ account has been suspended');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account-suspended',
            with: [
                'adminNote' => $this->site->admin_note,
            ],
        );
    }
}
