<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DapodikJadwal extends Model
{
    protected $fillable = [
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    const JENIS_LABEL = [
        'edit_ptk'   => 'Edit PTK',
        'tambah_ptk' => 'Tambah PTK',
    ];

    public function getLabelAttribute(): string
    {
        return self::JENIS_LABEL[$this->jenis] ?? $this->jenis;
    }
}
