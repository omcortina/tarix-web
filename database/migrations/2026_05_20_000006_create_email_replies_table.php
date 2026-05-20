<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbox_email_id')->constrained('inbox_emails')->onDelete('cascade');
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('email_account_id')->constrained('email_accounts')->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained('quote_templates')->onDelete('set null');
            $table->string('to_email');
            $table->string('subject');
            $table->longText('body');
            $table->boolean('success')->default(true);
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_replies');
    }
};
