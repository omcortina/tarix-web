<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sent_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classification_id')->nullable()->constrained('classifications')->onDelete('set null');
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('email_account_id')->constrained('email_accounts')->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained('quote_templates')->onDelete('set null');
            $table->string('to_email');
            $table->string('to_name')->nullable();
            $table->string('subject');
            $table->longText('body'); // Cuerpo final enviado
            $table->string('pdf_path')->nullable(); // Ruta del PDF adjunto
            $table->timestamp('sent_at')->nullable();
            $table->boolean('success')->default(true);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_quotes');
    }
};
