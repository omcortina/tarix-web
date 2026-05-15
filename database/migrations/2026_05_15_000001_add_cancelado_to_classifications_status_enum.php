<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE classifications MODIFY COLUMN status ENUM('Creado','Pendiente de pago','En proceso','Verificado','Aprobado','Cancelado') NOT NULL DEFAULT 'Creado'");
    }

    public function down(): void
    {
        // Revert rows with 'Cancelado' to 'Creado' before shrinking the enum
        DB::statement("UPDATE classifications SET status = 'Creado' WHERE status = 'Cancelado'");
        DB::statement("ALTER TABLE classifications MODIFY COLUMN status ENUM('Creado','Pendiente de pago','En proceso','Verificado','Aprobado') NOT NULL DEFAULT 'Creado'");
    }
};
