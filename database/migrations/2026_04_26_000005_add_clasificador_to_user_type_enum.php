<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar el ENUM para agregar CLASIFICADOR
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('ADMIN', 'EXTERNO', 'CLASIFICADOR') DEFAULT 'EXTERNO'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cambiar cualquier CLASIFICADOR a EXTERNO antes de revertir el ENUM
        DB::statement("UPDATE users SET user_type = 'EXTERNO' WHERE user_type = 'CLASIFICADOR'");
        // Revertir al ENUM original
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('ADMIN', 'EXTERNO') DEFAULT 'EXTERNO'");
    }
};
