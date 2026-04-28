<?php

namespace App\Mail;

use App\Models\ArticleComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewArticleCommentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ArticleComment $comment,
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
        $adminEmail = env('MAIL_FROM_ADDRESS', 'info@tarix.com.co');
        
        return new Envelope(
            to: [new Address($adminEmail, 'TARIX Admin')],
            from: new Address($adminEmail, env('MAIL_FROM_NAME', 'TARIX')),
            subject: "Nuevo Comentario en Artículo: {$this->comment->article->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-article-comment',
            with: [
                'comment' => $this->comment,
                'article' => $this->comment->article,
                'adminUrl' => route('admin.articles.index'),
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
