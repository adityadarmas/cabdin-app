<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panduans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('tipe', ['artikel', 'video'])->default('artikel');
            $table->text('konten')->nullable();
            $table->string('video_url', 1000)->nullable();
            $table->unsignedInteger('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panduans');
    }
};
