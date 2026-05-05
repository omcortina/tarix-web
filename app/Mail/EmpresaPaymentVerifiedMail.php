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

class EmpresaPaymentVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Classification $classification,
        public User $empresaUser,
        string $locale = 'es'
    ) {
        $this->locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->empresaUser->email, $this->empresaUser->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Pago Verificado - Radicado: {$this->classification->radicado}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.empresa-pago-verificado',
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
        return [];
    }
}
