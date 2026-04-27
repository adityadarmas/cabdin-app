<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProsedur extends Model
{
    protected $table = 'kategori_prosedurs';

    protected $fillable = [
        'nama',
        'urutan',
        'is_active',
    ];

    public function prosedurs()
    {
        return $this->hasMany(Prosedur::class, 'kategori_id')->orderBy('urutan');
    }

    public function prosedursAktif()
    {
        return $this->hasMany(Prosedur::class, 'kategori_id')
                    ->where('is_active', true)
                    ->orderBy('urutan');
    }
}
