<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('isi');
            $table->string('lampiran')->nullable()->after('gambar');
        });
        Schema::table('panduans', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('konten');
            $table->string('lampiran')->nullable()->after('gambar');
        });
    }

    public function down(): void
    {
        Schema::table('pengumumans', fn (Blueprint $table) => $table->dropColumn(['gambar', 'lampiran']));
        Schema::table('panduans', fn (Blueprint $table) => $table->dropColumn(['gambar', 'lampiran']));
    }
};
