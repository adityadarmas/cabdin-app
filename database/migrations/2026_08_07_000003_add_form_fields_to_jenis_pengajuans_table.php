<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->json('form_fields')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->dropColumn('form_fields');
        });
    }
};
