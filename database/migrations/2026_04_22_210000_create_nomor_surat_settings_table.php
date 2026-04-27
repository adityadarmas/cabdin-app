<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomor_surat_settings', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->default('SK');
            $table->unsignedInteger('counter')->default(0);
            $table->unsignedTinyInteger('padding')->default(3);
            $table->boolean('reset_yearly')->default(true);
            $table->unsignedSmallInteger('last_year')->nullable();
            $table->timestamps();
        });

        DB::table('nomor_surat_settings')->insert([
            'prefix'       => 'SK',
            'counter'      => 0,
            'padding'      => 3,
            'reset_yearly' => true,
            'last_year'    => now()->year,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_settings');
    }
};
