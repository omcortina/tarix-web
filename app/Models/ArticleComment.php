<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'article_id',
        'user_id',
        'author_name',
        'author_email',
        'content',
        'status',
    ];
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function replies()
    {
        return $this->hasMany(ArticleCommentReply::class)->orderBy('created_at', 'asc');
    }
    
    public function hasApprovedReply()
    {
        return $this->replies()->count() > 0;
    }
}
