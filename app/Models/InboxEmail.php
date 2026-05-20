<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboxEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_account_id',
        'message_id',
        'uid',
        'from_email',
        'from_name',
        'to_email',
        'subject',
        'body_text',
        'body_html',
        'received_at',
        'is_read',
        'has_attachments',
        'thread_id',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'is_read' => 'boolean',
        'has_attachments' => 'boolean',
    ];

    public function emailAccount()
    {
        return $this->belongsTo(EmailAccount::class);
    }

    public function replies()
    {
        return $this->hasMany(EmailReply::class);
    }
}
