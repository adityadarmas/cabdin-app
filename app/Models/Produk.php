<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'kategori',
        'deskripsi',
        'harga',
        'gambar',
        'link_produk',
        'is_active',
    ];

    public function operator()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
