<?php

namespace App\Http\Controllers;

use App\Models\DapodikJadwal;
use App\Models\KategoriProsedur;
use App\Models\Berita;
use App\Models\Produk;

class LandingController extends Controller
{
    public function index()
    {
        // Jika sudah login → langsung ke dashboard
        if (auth()->check()) {
            return redirect()->route('surat-masuk.index');
        }

        return view('landing', [
            'kategoriProsedur' => KategoriProsedur::where('is_active', true)
                                    ->orderBy('urutan')
                                    ->with(['prosedursAktif'])
                                    ->get(),
            'berita'           => Berita::where('is_active', 1)->latest()->limit(6)->get(),
            'produk'           => Produk::where('is_active', 1)->get(),
            'dapodikJadwals'   => DapodikJadwal::whereIn('jenis', ['edit_ptk', 'tambah_ptk'])
                                    ->get()
                                    ->keyBy('jenis'),
        ]);
    }

    public function error(){
        return view('error');
    }
}
