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
        Schema::create('item_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classification_item_id')->constrained('classification_items')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('restrict'); // clasificador
            $table->text('observations'); // observaciones del clasificador
            $table->text('client_response')->nullable(); // respuesta del cliente
            $table->enum('status', ['pendiente', 'respondido', 'verificado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_corrections');
    }
};
