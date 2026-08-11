<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('tagihans',function(Blueprint $table){$table->id();$table->string('judul');$table->text('deskripsi')->nullable();$table->timestamp('deadline_at');$table->boolean('is_active')->default(true);$table->timestamps();$table->index(['is_active','deadline_at']);}); } public function down(): void {Schema::dropIfExists('tagihans');} };
