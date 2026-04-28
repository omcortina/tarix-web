<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCorrection extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'classification_item_id',
        'requested_by',
        'observations',
        'client_response',
        'status',
    ];
    
    public function item()
    {
        return $this->belongsTo(ClassificationItem::class, 'classification_item_id');
    }
    
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    
    public function attachments()
    {
        return $this->hasMany(CorrectionAttachment::class);
    }
}

