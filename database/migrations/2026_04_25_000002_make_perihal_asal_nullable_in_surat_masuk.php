<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('perihal')->nullable()->change();
            $table->string('asal')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('perihal')->nullable(false)->change();
            $table->string('asal')->nullable(false)->change();
        });
    }
};
