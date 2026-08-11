<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriInformasi extends Model
{
    protected $table = 'kategori_informasi';
    protected $fillable = ['nama', 'parent_id', 'urutan', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function parent() { return $this->belongsTo(self::class, 'parent_id'); }
    public function children() { return $this->hasMany(self::class, 'parent_id')->orderBy('urutan'); }
    public function informasis() { return $this->hasMany(Berita::class, 'kategori_informasi_id'); }
}
