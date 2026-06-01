<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company',
        'nit',
        'phone',
        'city',
        'notes',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
