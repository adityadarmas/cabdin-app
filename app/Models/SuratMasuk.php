<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'perihal',
        'asal',
        'tgl_diterima',
        'tgl_kegiatan',
        'tgl_surat',
        'sifat',
        'jenis',
        'filepath',
        'tamu_id',
        'is_disposisi',
        'disposisi',
        'user_id',
        'status',
        'status_link',
        'sifat_dispo',
        'dengan_hormat_harap',
        'tracking_token',
        'token_expires_at',
        'keterangan',
        'ringkasan',
        'kitir_isi',
        'nama_pengambil',
        'nomor_agenda',
        'tgl_dikirim',
        'tgl_disetujui',
        'tgl_siap_diambil',
    ];

    protected $casts = [
        'tgl_diterima'     => 'date',
        'tgl_kegiatan'     => 'date',
        'tgl_surat'        => 'date',
        'token_expires_at' => 'datetime',
        'is_disposisi'     => 'boolean',
        'tgl_dikirim'      => 'datetime',
        'tgl_disetujui'    => 'datetime',
        'tgl_siap_diambil' => 'datetime',
    ];

    /**
     * Relasi ke Tamu
     */
    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'tamu_id');
    }

    /**
     * Relasi ke User (yang input/edit)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke surat keluar (opsional)
     */
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'surat_masuk_id');
    }

    /**
     * RELASI BARU: Banyak Staff Penerima Disposisi
     */
    public function penerima()
    {
        return $this->belongsToMany(
            User::class,
            'disposisi_penerima',
            'surat_masuk_id',
            'user_id'
        )
        ->withPivot('status', 'tanggal_dibaca', 'tanggal_selesai', 'catatan_staff')
        ->withTimestamps();
    }

    /**
     * Helper: Cek apakah sudah didisposisi
     */
    public function sudahDisposisi()
    {
        return $this->penerima()->count() > 0;
    }

    /**
     * Generate tracking token untuk tamu
     */
    public function generateTrackingToken()
    {
        $this->tracking_token = Str::random(40);
        $this->token_expires_at = null;
        $this->save();

        return $this->tracking_token;
    }

    public function isTokenValid()
    {
        return !empty($this->tracking_token);
    }

    /**
     * Get tracking URL
     */
    public function getTrackingUrlAttribute()
    {
        if (!$this->tracking_token) {
            return null;
        }

        return route('tracking.show', $this->tracking_token);
    }

    /**
     * Get status surat untuk tamu (simplified)
     */
    public function getStatusForTamuAttribute()
    {
        // Surat disposisi: cek progress penerima
        if ($this->is_disposisi && $this->penerima && $this->penerima->count() > 0) {
            $allSelesai = $this->penerima->every(fn($p) => $p->pivot->status === 'selesai');
            if ($allSelesai) {
                return ['label' => 'Selesai Diproses', 'color' => 'green', 'icon' => '✅',
                    'description' => 'Surat telah selesai diproses oleh seluruh tim'];
            }

            $anyDibaca = $this->penerima->contains(fn($p) => $p->pivot->status === 'dibaca');
            if ($anyDibaca) {
                return ['label' => 'Sedang Diproses', 'color' => 'yellow', 'icon' => '⚙️',
                    'description' => 'Surat sedang dalam proses penanganan'];
            }

            return ['label' => 'Didisposisikan', 'color' => 'blue', 'icon' => '📤',
                'description' => 'Surat telah diteruskan ke tim terkait'];
        }

        // Surat non-disposisi: map dari kolom status
        return match($this->status) {
            'siap_diambil' => ['label' => 'Selesai / Siap Diambil', 'color' => 'green', 'icon' => '🎉',
                'description' => 'Surat telah selesai diproses dan siap untuk diambil'],
            'disetujui'    => ['label' => 'Disetujui Pimpinan', 'color' => 'green', 'icon' => '✅',
                'description' => 'Surat telah disetujui dan sedang disiapkan'],
            'dikirim'      => ['label' => 'Sedang Diproses', 'color' => 'yellow', 'icon' => '⚙️',
                'description' => 'Surat sedang dalam proses persetujuan pimpinan'],
            default        => ['label' => 'Diterima', 'color' => 'blue', 'icon' => '📨',
                'description' => 'Surat telah diterima dan sedang diproses'],
        };
    }

    
}