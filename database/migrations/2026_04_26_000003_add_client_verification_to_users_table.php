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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('client_type', ['GENERAL', 'PREFERENCIAL'])->nullable()->after('user_type');
            $table->boolean('is_verified')->default(false)->after('client_type');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['client_type', 'is_verified', 'verified_at']);
        });
    }
};
