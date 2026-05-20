<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentQuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'sent_by',
        'email_account_id',
        'template_id',
        'to_email',
        'to_name',
        'subject',
        'body',
        'pdf_path',
        'sent_at',
        'success',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'success' => 'boolean',
    ];

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
