<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('npsn', 8)->nullable()->unique()->after('nama_sekolah');
            $table->enum('status_sekolah', ['negeri', 'swasta'])->nullable()->after('npsn');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['npsn']);
            $table->dropColumn(['npsn', 'status_sekolah']);
        });
    }
};
