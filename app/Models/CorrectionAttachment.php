<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectionAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'item_correction_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'type',
    ];
    
    public function itemCorrection()
    {
        return $this->belongsTo(ItemCorrection::class);
    }
}
