<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'konten',
        'tanggal',
        'thumbnail',
        'is_active'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
