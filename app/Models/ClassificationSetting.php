<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'price_general',
        'price_preferential',
        'iva_percentage',
        'max_items',
        'max_attachment_size_mb',
        'required_fields',
        'updated_by',
    ];
    
    protected $casts = [
        'required_fields' => 'array',
    ];
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
