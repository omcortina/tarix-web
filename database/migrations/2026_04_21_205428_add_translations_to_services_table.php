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
            UPDATE services SET
                title = JSON_OBJECT('es', title, 'en', title)
            WHERE title IS NOT NULL AND JSON_TYPE(title) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE services SET
                subtitle = JSON_OBJECT('es', subtitle, 'en', subtitle)
            WHERE subtitle IS NOT NULL AND JSON_TYPE(subtitle) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE services SET
                description = JSON_OBJECT('es', description, 'en', description)
            WHERE description IS NOT NULL AND JSON_TYPE(description) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE services SET
                what_is_section = JSON_OBJECT('es', what_is_section, 'en', what_is_section)
            WHERE what_is_section IS NOT NULL AND JSON_TYPE(what_is_section) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE services SET
                process_section = JSON_OBJECT('es', process_section, 'en', process_section)
            WHERE process_section IS NOT NULL AND JSON_TYPE(process_section) IS NULL
        SQL);
        
        \DB::statement(<<<SQL
            UPDATE services SET
                why_section = JSON_OBJECT('es', why_section, 'en', why_section)
            WHERE why_section IS NOT NULL AND JSON_TYPE(why_section) IS NULL
        SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is one-way - we convert to JSON but don't convert back
        // Because we don't know the original text format
    }
};
