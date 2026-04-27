<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE surat_masuk MODIFY COLUMN status ENUM('diterima','dikirim','disetujui','siap_diambil','disposisi') NOT NULL DEFAULT 'diterima'");
        }
    }

    public function down(): void
    {
        DB::table('surat_masuk')->where('status', 'disposisi')->update(['status' => 'diterima']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE surat_masuk MODIFY COLUMN status ENUM('diterima','dikirim','disetujui','siap_diambil') NOT NULL DEFAULT 'diterima'");
        }
    }
};
