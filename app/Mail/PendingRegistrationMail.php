<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendingRegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->user->email, $this->user->name)],
            from: new Address(env('MAIL_FROM_ADDRESS', 'info@tarix.com.co'), env('MAIL_FROM_NAME', 'TARIX')),
            subject: 'Tu registro está en proceso de verificación | TARIX',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pending-registration',
            with: [
                'user' => $this->user,
            ],
        );
    }
}
