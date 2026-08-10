<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->boolean('is_keterangan_enabled')->default(true)->after('is_active');
            $table->boolean('is_lampiran_enabled')->default(true)->after('is_keterangan_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->dropColumn(['is_keterangan_enabled', 'is_lampiran_enabled']);
        });
    }
};
