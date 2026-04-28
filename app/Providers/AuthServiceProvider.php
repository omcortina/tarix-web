<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ArticleComment;
use App\Models\ArticleCommentReply;
use App\Policies\ArticleCommentPolicy;
use App\Policies\ArticleCommentReplyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ArticleComment::class => ArticleCommentPolicy::class,
        ArticleCommentReply::class => ArticleCommentReplyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
