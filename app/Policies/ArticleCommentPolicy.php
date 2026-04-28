<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ArticleComment;

class ArticleCommentPolicy
{
    /**
     * Determine if admin can update/reply to a comment
     */
    public function update(User $user, ArticleComment $comment): bool
    {
        return $user->user_type === 'ADMIN';
    }
    
    /**
     * Determine if admin can delete a comment
     */
    public function delete(User $user, ArticleComment $comment): bool
    {
        return $user->user_type === 'ADMIN';
    }
}
