<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'classification_id',
        'status',
        'reference',
        'commercial_name',
        'technical_name',
        'matter',
        'function',
        'destination',
        'suggested_tariff',
        'observations',
        'revision_note',
        'final_tariff',
        'clasificador_observations',
    ];
    
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
    
    public function attachments()
    {
        return $this->hasMany(ClassificationAttachment::class);
    }
    
    public function corrections()
    {
        return $this->hasMany(ItemCorrection::class);
    }
}
