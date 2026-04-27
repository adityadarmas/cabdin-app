<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->boolean('is_disposisi')->default(false)->after('tamu_id');
            $table->text('keterangan')->nullable()->after('is_disposisi');
            $table->string('nama_pengambil')->nullable()->after('keterangan');
            $table->date('tgl_surat')->nullable()->after('nama_pengambil');
            $table->string('nomor_agenda')->nullable()->after('tgl_surat');
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn(['is_disposisi', 'keterangan', 'nama_pengambil', 'tgl_surat', 'nomor_agenda']);
        });
    }
};
