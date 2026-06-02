<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convertir tablas de bandeja de entrada a utf8mb4 para soporte completo de tildes/caracteres especiales
        DB::statement('ALTER TABLE inbox_emails CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        DB::statement('ALTER TABLE inbox_attachments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        DB::statement('ALTER TABLE email_replies CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE inbox_emails CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        DB::statement('ALTER TABLE inbox_attachments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        DB::statement('ALTER TABLE email_replies CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
    }
};
