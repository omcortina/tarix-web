<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sent_quotes', function (Blueprint $table) {
            $table->dropForeign(['classification_id']);
            $table->dropColumn('classification_id');
        });
    }

    public function down(): void
    {
        Schema::table('sent_quotes', function (Blueprint $table) {
            $table->foreignId('classification_id')->nullable()->constrained('classifications')->onDelete('set null');
        });
    }
};
