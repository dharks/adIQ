<?php

namespace App\Mail;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LicenseActivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Site $site) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Licence activated - ' . $this->site->domain);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.license-activated',
            with: [
                'siteUrl'       => $this->site->url,
                'domain'        => $this->site->domain,
                'activatedAt'   => $this->site->activated_at->format('d M Y, H:i') . ' UTC',
                'siteDetailUrl' => route('sites.show', $this->site),
            ],
        );
    }
}
