<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prosedur extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'is_active'
    ];
}
