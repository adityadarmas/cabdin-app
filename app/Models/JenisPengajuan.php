<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    protected $fillable = ['kategori_pengajuan_id', 'nama', 'deskripsi', 'form_fields', 'urutan', 'is_active', 'is_keterangan_enabled', 'is_lampiran_enabled', 'is_tagihan_dashboard', 'deadline_at'];

    protected $casts = [
        'form_fields' => 'array',
        'is_active' => 'boolean',
        'is_keterangan_enabled' => 'boolean',
        'is_lampiran_enabled' => 'boolean',
        'is_tagihan_dashboard' => 'boolean',
        'deadline_at' => 'datetime',
    ];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function kategoriPengajuan()
    {
        return $this->belongsTo(KategoriPengajuan::class);
    }
}
