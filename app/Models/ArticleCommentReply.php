<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCommentReply extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'article_comment_id',
        'user_id',
        'content',
    ];
    
    public function comment()
    {
        return $this->belongsTo(ArticleComment::class, 'article_comment_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
