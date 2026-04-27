<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing status values sebelum ubah enum
        DB::table('surat_masuk')->where('status', 'proses')->update(['status' => 'dikirim']);
        DB::table('surat_masuk')->where('status', 'selesai')->update(['status' => 'siap_diambil']);

        // Update enum di MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE surat_masuk MODIFY COLUMN status ENUM('diterima','dikirim','disetujui','siap_diambil') NOT NULL DEFAULT 'diterima'");
        }

        // Tambah kolom tanggal tracking status
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->timestamp('tgl_dikirim')->nullable()->after('status');
            $table->timestamp('tgl_disetujui')->nullable()->after('tgl_dikirim');
            $table->timestamp('tgl_siap_diambil')->nullable()->after('tgl_disetujui');
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn(['tgl_dikirim', 'tgl_disetujui', 'tgl_siap_diambil']);
        });

        DB::table('surat_masuk')->where('status', 'dikirim')->update(['status' => 'proses']);
        DB::table('surat_masuk')->where('status', 'siap_diambil')->update(['status' => 'selesai']);
        DB::table('surat_masuk')->where('status', 'disetujui')->update(['status' => 'proses']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE surat_masuk MODIFY COLUMN status ENUM('diterima','proses','selesai') NOT NULL DEFAULT 'diterima'");
        }
    }
};
