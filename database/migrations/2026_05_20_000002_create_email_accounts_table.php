<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre descriptivo de la cuenta
            $table->string('email'); // Dirección de correo

            // Configuración IMAP (para recibir/sincronizar)
            $table->string('imap_host')->nullable();
            $table->unsignedSmallInteger('imap_port')->default(993);
            $table->enum('imap_encryption', ['ssl', 'tls', 'starttls', 'none'])->default('ssl');
            $table->string('imap_username')->nullable();
            $table->text('imap_password')->nullable(); // Encriptado

            // Configuración SMTP (para enviar)
            $table->string('smtp_host')->nullable();
            $table->unsignedSmallInteger('smtp_port')->default(587);
            $table->enum('smtp_encryption', ['ssl', 'tls', 'starttls', 'none'])->default('tls');
            $table->string('smtp_username')->nullable();
            $table->text('smtp_password')->nullable(); // Encriptado
            $table->string('smtp_from_name')->nullable(); // Nombre remitente

            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_accounts');
    }
};
