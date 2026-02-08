<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('status', [
                'draft',
                'menunggu_persetujuan',
                'ditolak',
                'disetujui',
                'dikirim',
                'arsip'
            ])->after('filepath')->default('draft');

            $table->longText('isi_surat')->after('perihal')->nullable();
            $table->text('catatan_pimpinan')->nullable()->after('status');

            $table->date('tanggal_disetujui')->nullable()->after('catatan_pimpinan');
            $table->date('tanggal_kirim')->nullable()->after('tanggal_disetujui');
        });
    }

    public function down(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'status',
                'isi_surat',
                'catatan_pimpinan',
                'tanggal_disetujui',
                'tanggal_kirim'
            ]);
        });
    }
};
