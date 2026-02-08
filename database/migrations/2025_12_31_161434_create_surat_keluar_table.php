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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('surat_masuk_id')->nullable();
            $table->enum('jenis_surat', ['nota_dinas','surat_perintah_tugas']);
            $table->string('perihal');
            $table->string('nomor_surat');
            $table->string('filepath')->nullable();
            $table->timestamps();

            $table->foreign('surat_masuk_id')->references('id')->on('surat_masuk')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
