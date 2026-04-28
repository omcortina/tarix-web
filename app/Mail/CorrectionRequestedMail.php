<?php

namespace App\Mail;

use App\Models\ClassificationItem;
use App\Models\ItemCorrection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorrectionRequestedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ClassificationItem $item,
        public ItemCorrection $correction,
        string $locale = 'es'
    )
    {
        $this->locale($locale);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $classification = $this->item->classification;
        
        return new Envelope(
            to: [new Address($classification->user->email, $classification->user->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Revisión Requerida - Radicado: {$classification->radicado}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.correction-requested',
            with: [
                'item' => $this->item,
                'correction' => $this->correction,
                'classification' => $this->item->classification,
                'cliente' => $this->item->classification->user,
                'responseUrl' => route('user.classifications.items.corrections', [
                    'classification' => $this->item->classification,
                    'item' => $this->item,
                ]),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
