<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'form_fields', 'urutan', 'is_active', 'is_keterangan_enabled', 'is_lampiran_enabled'];

    protected $casts = [
        'form_fields' => 'array',
        'is_active' => 'boolean',
        'is_keterangan_enabled' => 'boolean',
        'is_lampiran_enabled' => 'boolean',
    ];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
