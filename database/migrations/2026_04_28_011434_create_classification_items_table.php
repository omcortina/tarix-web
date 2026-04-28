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
        Schema::create('classification_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classification_id');
            $table->enum('status', ['Pendiente', 'Verificado', 'Devolución'])->default('Pendiente');
            $table->string('reference')->nullable();
            $table->string('commercial_name');
            $table->text('technical_name')->nullable();
            $table->text('matter')->nullable();
            $table->text('function')->nullable();
            $table->text('destination')->nullable();
            $table->string('suggested_tariff')->nullable();
            $table->text('observations')->nullable();
            $table->text('revision_note')->nullable();
            $table->timestamps();
            
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade');
            $table->index('classification_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_items');
    }
};
