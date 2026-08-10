<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id', 'jenis_pengajuan_id', 'judul', 'isi', 'lampiran', 'data_tambahan', 'status', 'keterangan_admin', 'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'data_tambahan' => 'array',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisPengajuan()
    {
        return $this->belongsTo(JenisPengajuan::class);
    }
}
