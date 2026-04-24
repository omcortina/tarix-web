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
        Schema::create('article_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['image', 'youtube']); // Tipo de media
            $table->string('url'); // URL de imagen o YouTube
            $table->longText('description')->nullable(); // Descripción opcional
            $table->integer('order')->default(0); // Orden de aparición
            $table->timestamps();

            $table->index(['article_id', 'order']); // Índice para consultas eficientes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_media');
    }
};
