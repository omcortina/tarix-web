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
        Schema::table('classifications', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('total_cost');
            $table->decimal('iva_amount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('iva_percentage', 5, 2)->default(0)->after('iva_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classifications', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'iva_amount', 'iva_percentage']);
        });
    }
};
