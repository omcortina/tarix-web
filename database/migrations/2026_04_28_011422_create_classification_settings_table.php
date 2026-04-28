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
        Schema::create('classification_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_general', 8, 2)->default(0);
            $table->decimal('price_preferential', 8, 2)->default(0);
            $table->integer('max_items')->default(50);
            $table->integer('max_attachment_size_mb')->default(10);
            $table->json('required_fields')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_settings');
    }
};
