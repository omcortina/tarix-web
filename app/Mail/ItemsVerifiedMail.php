<?php

namespace App\Mail;

use App\Models\Classification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ItemsVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Classification $classification,
        public User $recipient,
        string $locale = 'es'
    ) {
        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->recipient->email, $this->recipient->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Items Verificados - Radicado: {$this->classification->radicado}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.items-verified',
            with: [
                'classification' => $this->classification,
                'recipient'      => $this->recipient,
                'items'          => $this->classification->items()->where('status', 'Verificado')->get(),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
