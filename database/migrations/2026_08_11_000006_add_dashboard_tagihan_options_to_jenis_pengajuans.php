<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::table('jenis_pengajuans',function(Blueprint $table){$table->boolean('is_tagihan_dashboard')->default(false)->after('is_lampiran_enabled');$table->timestamp('deadline_at')->nullable()->after('is_tagihan_dashboard');}); } public function down(): void { Schema::table('jenis_pengajuans',function(Blueprint $table){$table->dropColumn(['is_tagihan_dashboard','deadline_at']);}); } };
