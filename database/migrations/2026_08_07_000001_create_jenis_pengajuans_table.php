<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('jenis_pengajuans')->insert([
            ['nama' => 'Pengajuan Tambah PTK', 'deskripsi' => 'Isi data PTK baru dan lampirkan dokumen pendukung yang diperlukan.', 'urutan' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pengajuan Edit PTK', 'deskripsi' => 'Jelaskan data PTK yang akan diperbarui dan sertakan bukti pendukung.', 'urutan' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pengajuan Tarik Data PTK', 'deskripsi' => 'Tuliskan identitas PTK dan alasan penarikan data secara lengkap.', 'urutan' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Approval Tarik Siswa Non-Dapo', 'deskripsi' => 'Masukkan data siswa, asal sekolah, dan alasan pengajuan persetujuan.', 'urutan' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pengajuan Reset Akun SIMPKB Guru', 'deskripsi' => 'Cantumkan nama guru, email/akun SIMPKB, serta alasan reset akun.', 'urutan' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pengajuan Guru Swasta Menjadi Kepala Sekolah', 'deskripsi' => 'Jelaskan perubahan jabatan yang diajukan dan lampirkan dokumen penetapan.', 'urutan' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pengajuans');
    }
};
