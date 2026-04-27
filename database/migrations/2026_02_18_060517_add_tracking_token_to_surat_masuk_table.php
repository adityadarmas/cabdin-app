<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('tracking_token', 64)->unique()->nullable()->after('filepath');
            $table->timestamp('token_expires_at')->nullable()->after('tracking_token');
        });
    }

    public function down()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn(['tracking_token', 'token_expires_at']);
        });
    }
};