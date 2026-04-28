<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'radicado',
        'type',
        'total_cost',
        'status',
        'clasificador_id',
        'payment_verified',
        'payment_verified_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function clasificador()
    {
        return $this->belongsTo(User::class, 'clasificador_id');
    }
    
    public function items()
    {
        return $this->hasMany(ClassificationItem::class);
    }
    
    public function histories()
    {
        return $this->hasMany(ClassificationHistory::class)->orderByDesc('created_at');
    }
    
    public function attachments()
    {
        return $this->hasManyThrough(ClassificationAttachment::class, ClassificationItem::class);
    }
}
