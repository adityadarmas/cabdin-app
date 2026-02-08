<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';

    protected $fillable = [
        'user_id',
        'nomor_surat',
        'tujuan',
        'perihal',
        'isi_surat',
        'status',
        'catatan_pimpinan',
        'tanggal_disetujui',
        'tanggal_kirim'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
     public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }
}



