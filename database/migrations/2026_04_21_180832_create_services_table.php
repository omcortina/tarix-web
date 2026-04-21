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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->longText('title');
            $table->longText('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->text('icon_class')->nullable();
            $table->longText('what_is_section')->nullable();
            $table->longText('process_section')->nullable();
            $table->longText('why_section')->nullable();
            $table->json('features')->nullable();
            $table->json('stats')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
