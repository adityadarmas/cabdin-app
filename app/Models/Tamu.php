<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $table = 'tamu';

    protected $fillable = [
        'nama',
        'asal',
        'keperluan',
    ];

    /**
     * Relasi ke surat masuk
     */
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'tamu_id');
    }
}
