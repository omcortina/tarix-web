<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'inbox_email_id',
        'sent_by',
        'email_account_id',
        'template_id',
        'to_email',
        'subject',
        'body',
        'success',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'success' => 'boolean',
    ];

    public function inboxEmail()
    {
        return $this->belongsTo(InboxEmail::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function emailAccount()
    {
        return $this->belongsTo(EmailAccount::class);
    }

    public function template()
    {
        return $this->belongsTo(QuoteTemplate::class, 'template_id');
    }
}
