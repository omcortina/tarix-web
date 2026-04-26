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
        // Actualizar usuarios específicos del seeder a ADMIN
        DB::table('users')
            ->whereIn('email', ['admin@tarix.com.co', 'admin2@tarix.com.co'])
            ->update(['user_type' => 'ADMIN']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->whereIn('email', ['admin@tarix.com.co', 'admin2@tarix.com.co'])
            ->update(['user_type' => 'EXTERNO']);
    }
};
