<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('panduans')) {
            return;
        }

        if (Schema::hasColumn('panduans', 'tipe') && Schema::hasColumn('panduans', 'video_url')) {
            DB::table('panduans')->where('tipe', 'video')->orderBy('id')->each(function ($panduan) {
                if (blank($panduan->konten) && filled($panduan->video_url)) {
                    DB::table('panduans')->where('id', $panduan->id)->update([
                        'konten' => '<p>Video panduan sebelumnya dapat dibuka di <a href="'.e($panduan->video_url).'" target="_blank" rel="noopener noreferrer">tautan ini</a>.</p>',
                    ]);
                }
            });
        }

        $columns = array_filter(['tipe', 'video_url'], fn (string $column) => Schema::hasColumn('panduans', $column));
        if ($columns) {
            Schema::table('panduans', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('panduans')) {
            return;
        }

        Schema::table('panduans', function (Blueprint $table) {
            if (! Schema::hasColumn('panduans', 'tipe')) {
                $table->string('tipe', 20)->default('artikel')->after('judul');
            }
            if (! Schema::hasColumn('panduans', 'video_url')) {
                $table->string('video_url', 1000)->nullable()->after('konten');
            }
        });
    }
};
