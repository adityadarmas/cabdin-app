<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'kategori_informasi_id',
        'judul',
        'konten',
        'tanggal',
        'thumbnail',
        'is_active'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kategoriInformasi()
    {
        return $this->belongsTo(KategoriInformasi::class);
    }
}
