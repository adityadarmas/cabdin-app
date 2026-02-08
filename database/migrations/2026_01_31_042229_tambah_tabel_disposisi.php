<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->enum('sifat_dispo', ['sangat_segera', 'segera', 'rahasia'])
                  ->nullable()
                  ->after('disposisi');

            $table->string('dengan_hormat_harap')
                  ->nullable()
                  ->after('sifat_dispo');
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn([
                'sifat_dispo',
                'dengan_hormat_harap'
            ]);
        });
    }
};
