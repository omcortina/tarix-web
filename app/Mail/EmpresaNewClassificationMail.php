<?php

namespace App\Mail;

use App\Models\Classification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmpresaNewClassificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Classification $classification,
        public User $empresaUser,
        public ?string $pdfPath = null,
        string $locale = 'es'
    ) {
        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->empresaUser->email, $this->empresaUser->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Nueva Clasificación Registrada - {$this->classification->radicado}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.empresa-nueva-clasificacion',
            with: [
                'classification' => $this->classification,
                'empresaUser'    => $this->empresaUser,
                'cliente'        => $this->classification->user,
                'dashboardUrl'   => route('user.empresa.classifications'),
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
