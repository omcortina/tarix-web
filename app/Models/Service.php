<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'subtitle', 'description', 'what_is_section', 'process_section', 'why_section'];

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'description',
        'icon_class',
        'what_is_section',
        'process_section',
        'why_section',
        'features',
        'stats',
        'published',
        'show_in_footer',
    ];

    public function usefulResources()
    {
        return $this->hasMany(UsefulResource::class)->orderBy('order');
    }

    protected $casts = [
        'features' => 'array',
        'stats' => 'array',
        'published' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
