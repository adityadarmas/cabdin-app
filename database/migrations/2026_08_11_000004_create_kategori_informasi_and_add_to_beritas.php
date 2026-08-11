<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('kategori_informasi', function (Blueprint $table) { $table->id(); $table->string('nama'); $table->foreignId('parent_id')->nullable()->constrained('kategori_informasi')->nullOnDelete(); $table->integer('urutan')->default(1); $table->boolean('is_active')->default(true); $table->timestamps(); });
        Schema::table('beritas', function (Blueprint $table) { $table->foreignId('kategori_informasi_id')->nullable()->after('id')->constrained('kategori_informasi')->nullOnDelete(); $table->index(['kategori_informasi_id','created_at']); });
    }
    public function down(): void { Schema::table('beritas', function (Blueprint $table) { $table->dropIndex(['kategori_informasi_id','created_at']); $table->dropConstrainedForeignId('kategori_informasi_id'); }); Schema::dropIfExists('kategori_informasi'); }
};
