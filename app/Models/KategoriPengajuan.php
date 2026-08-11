<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPengajuan extends Model
{
    protected $table = 'kategori_pengajuans';

    protected $fillable = ['nama', 'urutan', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function jenisPengajuans()
    {
        return $this->hasMany(JenisPengajuan::class);
    }
}
