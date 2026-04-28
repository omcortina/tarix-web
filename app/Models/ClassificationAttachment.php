<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'classification_item_id',
        'file_path',
        'file_name',
        'file_size',
    ];
    
    public function classificationItem()
    {
        return $this->belongsTo(ClassificationItem::class);
    }
}
