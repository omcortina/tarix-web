<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'classification_id',
        'status',
        'note',
        'changed_by',
    ];
    
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
    
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
