<?php

namespace App\Http\Controllers;

use App\Models\DapodikJadwal;
use App\Models\KategoriProsedur;
use App\Models\Berita;
use App\Models\KategoriInformasi;
use App\Models\Produk;

class LandingController extends Controller
{
    public function index()
    {
        // Jika sudah login → langsung ke dashboard
        if (auth()->check()) {
            return redirect()->route(match (auth()->user()->role) {
                'admin' => 'admin.users.index',
                'operator' => 'operator.dashboard',
                default => 'surat-masuk.index',
            });
        }

        $produkQuery = Produk::where('is_active', true);

        return view('landing', [
            'kategoriProsedur' => KategoriProsedur::where('is_active', true)
                                    ->orderBy('urutan')
                                    ->with(['prosedursAktif'])
                                    ->get(),
            'berita'           => Berita::with('kategoriInformasi')->where('is_active', 1)->latest()->limit(6)->get(),
            'kategoriInformasi' => KategoriInformasi::where('is_active', true)
                                    ->whereNull('parent_id')
                                    ->with(['children' => fn ($query) => $query->where('is_active', true)->orderBy('urutan')])
                                    ->orderBy('urutan')
                                    ->get(),
            // Landing page hanya menampilkan maksimal delapan produk. Ambil satu
            // data tambahan untuk menentukan apakah tombol "Lihat Semua" perlu
            // ditampilkan, bukan seluruh isi tabel produk.
            'produk'           => (clone $produkQuery)
                                    ->latest()
                                    ->limit(9)
                                    ->get(['id', 'nama', 'kategori', 'harga', 'gambar']),
            'produkCount'      => $produkQuery->count(),
            'dapodikJadwals'   => DapodikJadwal::whereIn('jenis', ['edit_ptk', 'tambah_ptk'])
                                    ->get()
                                    ->keyBy('jenis'),
        ]);
    }

    public function error(){
        return view('error');
    }
}
