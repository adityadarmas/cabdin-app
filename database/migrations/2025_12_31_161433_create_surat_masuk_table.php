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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('perihal');
            $table->string('asal');
            $table->date('tgl_diterima');
            $table->date('tgl_kegiatan')->nullable();
            $table->enum('sifat', ['segera','penting','biasa'])->default('biasa');
            $table->enum('jenis', ['mutasi','izin_penelitian','pemberitahuan'])->default('pemberitahuan');
            $table->string('filepath')->nullable();
            $table->unsignedBigInteger('tamu_id');
            $table->text('disposisi')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['diterima','proses','selesai'])->default('proses');
            $table->string('status_link')->nullable();
            $table->timestamps();

            $table->foreign('tamu_id')->references('id')->on('tamu')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
