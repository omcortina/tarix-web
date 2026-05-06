<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyRegistrationLinkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Company $company,
        public string $registrationUrl,
        public string $recipientEmail
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->recipientEmail)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: 'Invitación de registro - ' . $this->company->name . ' | TARIX',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.company-registration-link',
            with: [
                'company' => $this->company,
                'registrationUrl' => $this->registrationUrl,
            ],
        );
    }
}
