<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: modificar el ENUM para agregar COTIZADOR
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('ADMIN','EXTERNO','CLASIFICADOR','EMPRESA','COTIZADOR') NOT NULL DEFAULT 'EXTERNO'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('ADMIN','EXTERNO','CLASIFICADOR','EMPRESA') NOT NULL DEFAULT 'EXTERNO'");
    }
};
