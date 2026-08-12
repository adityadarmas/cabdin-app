<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanKonfirmasi extends Model
{
    protected $table = 'tagihan_konfirmasi';

    protected $fillable = ['jenis_pengajuan_id', 'user_id', 'dibaca_at'];

    protected $casts = ['dibaca_at' => 'datetime'];

    public function jenisPengajuan()
    {
        return $this->belongsTo(JenisPengajuan::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
