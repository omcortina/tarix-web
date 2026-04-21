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
        // Convert existing text columns to JSON format for Spatie translations
        \DB::statement(<<<SQL
            UPDATE articles SET
                title = JSON_OBJECT('es', title, 'en', title)
            WHERE title IS NOT NULL AND JSON_TYPE(title) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE articles SET
                excerpt = JSON_OBJECT('es', excerpt, 'en', excerpt)
            WHERE excerpt IS NOT NULL AND JSON_TYPE(excerpt) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE articles SET
                content = JSON_OBJECT('es', content, 'en', content)
            WHERE content IS NOT NULL AND JSON_TYPE(content) IS NULL
        SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is one-way - we convert to JSON but don't convert back
    }
};
