<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'form_fields', 'urutan', 'is_active'];

    protected $casts = ['form_fields' => 'array'];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
