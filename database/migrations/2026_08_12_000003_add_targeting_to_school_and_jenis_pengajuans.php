<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bentuk_pendidikan', 10)->nullable()->after('status_sekolah');
        });
        Schema::table('jenis_pengajuans', function (Blueprint $table) {
            $table->string('target_bentuk_pendidikan', 10)->default('semua')->after('deadline_at');
            $table->string('target_status_sekolah', 10)->default('semua')->after('target_bentuk_pendidikan');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pengajuans', fn (Blueprint $table) => $table->dropColumn(['target_bentuk_pendidikan', 'target_status_sekolah']));
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('bentuk_pendidikan'));
    }
};
