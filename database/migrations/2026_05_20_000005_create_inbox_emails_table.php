<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbox_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_account_id')->constrained('email_accounts')->onDelete('cascade');
            $table->string('message_id')->nullable(); // ID único del servidor IMAP
            $table->string('uid')->nullable(); // UID en el servidor IMAP
            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->string('to_email')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body_text')->nullable(); // Texto plano
            $table->longText('body_html')->nullable(); // HTML
            $table->timestamp('received_at')->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('has_attachments')->default(false);
            $table->string('thread_id')->nullable(); // Para agrupar hilos
            $table->timestamps();

            $table->unique(['email_account_id', 'uid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox_emails');
    }
};
