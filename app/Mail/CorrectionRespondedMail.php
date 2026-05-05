<?php

namespace App\Mail;

use App\Models\Classification;
use App\Models\ClassificationItem;
use App\Models\ItemCorrection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorrectionRespondedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public ClassificationItem $item,
        public ItemCorrection $correction,
        string $locale = 'es'
    ) {
        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        $clasificador = $this->item->classification->clasificador;

        return new Envelope(
            to: [new Address($clasificador->email, $clasificador->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Corrección Respondida - Radicado: {$this->item->classification->radicado}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.correccion-respondida',
            with: [
                'item'           => $this->item,
                'correction'     => $this->correction,
                'classification' => $this->item->classification,
                'cliente'        => $this->item->classification->user,
                'clasificador'   => $this->item->classification->clasificador,
                'dashboardUrl'   => route('clasificador.show', $this->item->classification),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
