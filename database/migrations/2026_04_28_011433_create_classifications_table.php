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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('radicado')->unique();
            $table->enum('type', ['general', 'unidad_funcional'])->default('general');
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->enum('status', ['Creado', 'Pendiente de pago', 'En proceso', 'Verificado', 'Aprobado'])->default('Creado');
            $table->unsignedBigInteger('clasificador_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clasificador_id')->references('id')->on('users')->onDelete('set null');
            $table->index('radicado');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifications');
    }
};
