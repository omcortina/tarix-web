<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sent_quotes', function (Blueprint $table) {
            $table->text('pdf_path')->nullable()->change();
        });

        // Migrar rutas simples existentes al nuevo formato JSON array
        DB::table('sent_quotes')
            ->whereNotNull('pdf_path')
            ->where('pdf_path', 'not like', '[%')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('sent_quotes')
                        ->where('id', $row->id)
                        ->update(['pdf_path' => json_encode([$row->pdf_path])]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('sent_quotes', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->change();
        });
    }
};
