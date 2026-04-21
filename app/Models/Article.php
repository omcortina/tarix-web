<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'excerpt', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'user_id',
        'published',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
