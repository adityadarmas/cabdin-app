<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NomorSuratSetting extends Model
{
    protected $table = 'nomor_surat_settings';

    protected $fillable = [
        'counter',
        'padding',
    ];

    public static function generateNext(): string
    {
        return DB::transaction(function () {
            $setting = self::lockForUpdate()->firstOrFail();

            $setting->counter += 1;
            $setting->save();

            return str_pad($setting->counter, $setting->padding, '0', STR_PAD_LEFT);
        });
    }
}
