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
        Schema::table('classification_items', function (Blueprint $table) {
            $table->string('final_tariff')->nullable()->after('suggested_tariff')->comment('Subpartida final asignada por el clasificador');
            $table->text('clasificador_observations')->nullable()->after('revision_note')->comment('Observaciones del clasificador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classification_items', function (Blueprint $table) {
            $table->dropColumn(['final_tariff', 'clasificador_observations']);
        });
    }
};
