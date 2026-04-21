<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UsefulResource extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title'];

    protected $fillable = ['service_id', 'title', 'url', 'order', 'is_active'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
