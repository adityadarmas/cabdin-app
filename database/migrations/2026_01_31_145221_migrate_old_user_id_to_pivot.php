<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $surat = DB::table('surat_masuk')
            ->whereNotNull('user_id')
            ->get();

        foreach ($surat as $s) {
            DB::table('surat_masuk_user')->insertOrIgnore([
                'surat_masuk_id' => $s->id,
                'user_id'        => $s->user_id,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('surat_masuk_user')->truncate();
    }
};
