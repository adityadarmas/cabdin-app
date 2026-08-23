<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panduan extends Model
{
    protected $fillable = ['judul', 'konten', 'gambar', 'lampiran', 'urutan', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
