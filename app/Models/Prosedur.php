<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prosedur extends Model
{
    protected $fillable = [
        'kategori_id',
        'judul',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProsedur::class, 'kategori_id');
    }
}
