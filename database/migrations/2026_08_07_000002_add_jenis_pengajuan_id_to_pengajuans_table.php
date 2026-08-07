<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->foreignId('jenis_pengajuan_id')->nullable()->after('user_id')->constrained('jenis_pengajuans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('jenis_pengajuan_id');
        });
    }
};
