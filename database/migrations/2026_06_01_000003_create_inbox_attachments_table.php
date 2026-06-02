<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbox_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbox_email_id')->constrained('inbox_emails')->onDelete('cascade');
            $table->string('original_name');
            $table->string('stored_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('content_id')->nullable(); // Para referencias cid: en el HTML
            $table->boolean('is_inline')->default(false);
            $table->string('storage_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox_attachments');
    }
};
