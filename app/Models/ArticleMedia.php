<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ArticleMedia extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['description'];

    protected $fillable = [
        'article_id',
        'type',
        'url',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Obtener el embed de YouTube si es video
     */
    public function getYoutubeEmbedAttribute()
    {
        if ($this->type === 'youtube') {
            $url = $this->url;
            
            // Extraer ID de diferentes formatos de URL
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $url, $match)) {
                return $match[1];
            }
            // Si solo es un ID
            if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
                return $url;
            }
        }
        return null;
    }
}
