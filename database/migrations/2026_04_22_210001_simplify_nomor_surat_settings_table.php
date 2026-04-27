<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nomor_surat_settings', function (Blueprint $table) {
            $table->dropColumn(['prefix', 'reset_yearly', 'last_year']);
        });
    }

    public function down(): void
    {
        Schema::table('nomor_surat_settings', function (Blueprint $table) {
            $table->string('prefix')->default('SK');
            $table->boolean('reset_yearly')->default(true);
            $table->unsignedSmallInteger('last_year')->nullable();
        });
    }
};
