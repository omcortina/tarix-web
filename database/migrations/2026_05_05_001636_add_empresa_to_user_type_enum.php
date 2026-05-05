<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('ADMIN', 'EXTERNO', 'CLASIFICADOR', 'EMPRESA') DEFAULT 'EXTERNO'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE users SET user_type = 'EXTERNO' WHERE user_type = 'EMPRESA'");
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('ADMIN', 'EXTERNO', 'CLASIFICADOR') DEFAULT 'EXTERNO'");
    }
};
