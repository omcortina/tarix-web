<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EmailAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'imap_host',
        'imap_port',
        'imap_encryption',
        'imap_username',
        'imap_password',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'smtp_username',
        'smtp_password',
        'smtp_from_name',
        'is_active',
        'created_by',
    ];

    protected $hidden = ['imap_password', 'smtp_password'];

    /**
     * Guardar contraseña IMAP encriptada
     */
    public function setImapPasswordAttribute($value): void
    {
        $this->attributes['imap_password'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Obtener contraseña IMAP desencriptada
     */
    public function getImapPasswordAttribute($value): ?string
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Guardar contraseña SMTP encriptada
     */
    public function setSmtpPasswordAttribute($value): void
    {
        $this->attributes['smtp_password'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Obtener contraseña SMTP desencriptada
     */
    public function getSmtpPasswordAttribute($value): ?string
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function inboxEmails()
    {
        return $this->hasMany(InboxEmail::class);
    }

    public function sentQuotes()
    {
        return $this->hasMany(SentQuote::class);
    }
}
