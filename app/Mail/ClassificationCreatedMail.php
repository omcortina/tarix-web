<?php

namespace App\Mail;

use App\Models\Classification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassificationCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public bool $showPrice;

    public function __construct(
        public Classification $classification,
        public ?string $pdfPath = null,
        string $locale = 'es'
    ) {
        $this->locale($locale);
        $user = $this->classification->user;
        $this->showPrice = !$user->company_id || ($user->company && $user->company->isTarix());
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->classification->user->email, $this->classification->user->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Clasificación Registrada - Radicado: {$this->classification->radicado}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.classification-created',
            with: [
                'classification' => $this->classification,
                'cliente'        => $this->classification->user,
                'showPrice'      => $this->showPrice,
                'proceduresUrl'  => route('user.procedures'),
            ]
        );
    }

    public function attachments(): array
    {
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            return [
                Attachment::fromPath($this->pdfPath)
                    ->as('Factura-' . $this->classification->radicado . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
