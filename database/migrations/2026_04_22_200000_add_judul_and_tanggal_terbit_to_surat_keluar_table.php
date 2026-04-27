<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->string('judul_surat')->nullable()->after('nomor_surat');
            $table->date('tanggal_terbit')->nullable()->after('judul_surat');
        });
    }

    public function down(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropColumn(['judul_surat', 'tanggal_terbit']);
        });
    }
};
