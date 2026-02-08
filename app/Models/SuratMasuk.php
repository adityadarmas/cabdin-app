<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'perihal',
        'asal',
        'tgl_diterima',
        'tgl_kegiatan',
        'sifat',
        'jenis',
        'filepath',
        'tamu_id',
        'disposisi',
        'user_id',
        'status',
        'status_link',
        'sifat_dispo',
        'dengan_hormat_harap',
    ];

    protected $casts = [
        'tgl_diterima' => 'date',
        'tgl_kegiatan' => 'date',
    ];

    /**
     * Relasi ke Tamu
     */
    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'tamu_id');
    }

    /**
     * Relasi ke User (yang input/edit)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke surat keluar (opsional)
     */
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'surat_masuk_id');
    }

    
}
