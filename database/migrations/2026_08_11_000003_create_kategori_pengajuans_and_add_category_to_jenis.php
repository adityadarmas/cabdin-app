<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $categoryId = DB::table('kategori_pengajuans')->insertGetId([
            'nama' => 'Umum',
            'urutan' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->foreignId('kategori_pengajuan_id')->nullable()->after('id')->constrained('kategori_pengajuans')->nullOnDelete();
        });

        DB::table('jenis_pengajuans')->update(['kategori_pengajuan_id' => $categoryId]);
    }

    public function down(): void
    {
        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_pengajuan_id');
        });
        Schema::dropIfExists('kategori_pengajuans');
    }
};
