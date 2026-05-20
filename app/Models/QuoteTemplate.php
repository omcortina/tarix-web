<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'body',
        'is_active',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sentQuotes()
    {
        return $this->hasMany(SentQuote::class, 'template_id');
    }

    public function emailReplies()
    {
        return $this->hasMany(EmailReply::class, 'template_id');
    }
}
