<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InboxAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inbox_email_id',
        'original_name',
        'stored_name',
        'mime_type',
        'size',
        'content_id',
        'is_inline',
        'storage_path',
    ];

    protected $casts = [
        'is_inline' => 'boolean',
        'size'      => 'integer',
    ];

    public function inboxEmail()
    {
        return $this->belongsTo(InboxEmail::class);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    public function formattedSize(): string
    {
        $bytes = $this->size;
        if ($bytes < 1024) {
            return $bytes . ' B';
        }
        if ($bytes < 1048576) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return round($bytes / 1048576, 1) . ' MB';
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->storage_path);
    }
}
