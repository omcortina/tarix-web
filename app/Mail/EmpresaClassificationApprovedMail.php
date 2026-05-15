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

class EmpresaClassificationApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Classification $classification,
        public User $empresaUser,
        public ?string $pdfPath = null,
        public bool $attachClassificationPdf = false,
        string $locale = 'es'
    ) {
        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->empresaUser->email, $this->empresaUser->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Clasificación Aprobada - Radicado: {$this->classification->radicado}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.empresa-clasificacion-aprobada',
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
        $attachments = [];

        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $attachments[] = Attachment::fromPath($this->pdfPath)
                ->as('Factura-' . $this->classification->radicado . '.pdf')
                ->withMime('application/pdf');
        }

        if ($this->attachClassificationPdf) {
            $this->classification->loadMissing(['user.company', 'items', 'clasificador']);
            $pdfContent = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.classification', [
                'classification' => $this->classification,
            ])->setPaper('a4', 'portrait')->output();

            $filename = 'clasificacion-' . $this->classification->radicado . '.pdf';
            $attachments[] = Attachment::fromData(fn () => $pdfContent, $filename)
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
