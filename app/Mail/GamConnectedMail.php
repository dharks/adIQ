<?php

namespace App\Mail;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GamConnectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Site $site) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Google Ad Manager connected - ' . ($this->site->domain ?: $this->site->url));
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.gam-connected',
            with: [
                'siteUrl'       => $this->site->url,
                'domain'        => $this->site->domain ?: $this->site->url,
                'gamEmail'      => $this->site->gam_email,
                'networkName'   => $this->site->gam_network_name ?: 'Unknown',
                'networkId'     => $this->site->gam_network_id,
                'connectedAt'   => now()->format('d M Y, H:i') . ' UTC',
                'siteDetailUrl' => route('sites.show', $this->site),
            ],
        );
    }
}
