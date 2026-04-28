<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('author_name');
            $table->string('author_email');
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('article_id');
            $table->index('status');
        });
        
        Schema::create('article_comment_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_comment_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->timestamps();
            
            $table->foreign('article_comment_id')->references('id')->on('article_comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('article_comment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_comment_replies');
        Schema::dropIfExists('article_comments');
    }
};
