<?php

namespace App\Http\Controllers;

use App\Models\Prosedur;
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
            'prosedur' => Prosedur::where('is_active', 1)->orderBy('urutan')->get(),
            'berita'   => Berita::where('is_active', 1)->latest()->limit(3)->get(),
            'produk'   => Produk::where('is_active', 1)->get(),
        ]);
    }

    public function error(){
        return view('error');
    }
}
