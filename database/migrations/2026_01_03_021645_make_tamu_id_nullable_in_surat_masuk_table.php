<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('surat_masuk', function (Blueprint $table) {
        $table->unsignedBigInteger('tamu_id')->nullable()->change();
        $table->unsignedBigInteger('user_id')->nullable()->change();
    });
}

public function down()
{
    Schema::table('surat_masuk', function (Blueprint $table) {
        $table->unsignedBigInteger('tamu_id')->nullable(false)->change();
        $table->unsignedBigInteger('user_id')->nullable(false)->change();
    });
}

};
