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
        Schema::create('classification_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classification_item_id');
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size');
            $table->timestamps();
            
            $table->foreign('classification_item_id')->references('id')->on('classification_items')->onDelete('cascade');
            $table->index('classification_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_attachments');
    }
};
