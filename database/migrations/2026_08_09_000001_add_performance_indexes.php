<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Indeks disesuaikan dengan query yang paling sering digunakan oleh halaman
     * publik, daftar pengajuan operator, dan filter pengajuan admin.
     */
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->index(['is_active', 'created_at'], 'beritas_active_created_index');
        });

        Schema::table('produks', function (Blueprint $table) {
            $table->index(['is_active', 'created_at'], 'produks_active_created_index');
            $table->index(['user_id', 'created_at'], 'produks_user_created_index');
        });

        Schema::table('kategori_prosedurs', function (Blueprint $table) {
            $table->index(['is_active', 'urutan'], 'kategori_prosedurs_active_order_index');
        });

        Schema::table('prosedurs', function (Blueprint $table) {
            $table->index(['kategori_id', 'is_active', 'urutan'], 'prosedurs_category_active_order_index');
        });

        Schema::table('pengajuans', function (Blueprint $table) {
            $table->index(['user_id', 'jenis_pengajuan_id', 'submitted_at'], 'pengajuans_user_type_submitted_index');
            $table->index(['status', 'created_at'], 'pengajuans_status_created_index');
            $table->index(['jenis_pengajuan_id', 'created_at'], 'pengajuans_type_created_index');
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex('beritas_active_created_index');
        });

        Schema::table('produks', function (Blueprint $table) {
            $table->dropIndex('produks_active_created_index');
            $table->dropIndex('produks_user_created_index');
        });

        Schema::table('kategori_prosedurs', function (Blueprint $table) {
            $table->dropIndex('kategori_prosedurs_active_order_index');
        });

        Schema::table('prosedurs', function (Blueprint $table) {
            $table->dropIndex('prosedurs_category_active_order_index');
        });

        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropIndex('pengajuans_user_type_submitted_index');
            $table->dropIndex('pengajuans_status_created_index');
            $table->dropIndex('pengajuans_type_created_index');
        });
    }
};
