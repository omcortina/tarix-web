<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ArticleCommentReply;

class ArticleCommentReplyPolicy
{
    /**
     * Determine if admin can delete a reply
     */
    public function delete(User $user, ArticleCommentReply $reply): bool
    {
        return $user->user_type === 'ADMIN';
    }
}
