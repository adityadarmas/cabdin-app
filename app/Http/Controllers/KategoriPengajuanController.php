<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengajuan;
use Illuminate\Http\Request;

class KategoriPengajuanController extends Controller
{
    public function index()
    {
        $kategoriPengajuans = KategoriPengajuan::withCount('jenisPengajuans')->orderBy('urutan')->get();

        return view('dashboard.kategori_pengajuan.index', compact('kategoriPengajuans'));
    }

    public function store(Request $request)
    {
        KategoriPengajuan::create($this->validated($request));

        return back()->with('success', 'Kategori pengumpulan data berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriPengajuan $kategoriPengajuan)
    {
        $kategoriPengajuan->update($this->validated($request));

        return back()->with('success', 'Kategori pengumpulan data berhasil diperbarui.');
    }

    public function destroy(KategoriPengajuan $kategoriPengajuan)
    {
        if ($kategoriPengajuan->jenisPengajuans()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih dipakai oleh jenis pengumpulan data. Pindahkan jenis tersebut terlebih dahulu atau nonaktifkan kategori.');
        }

        $kategoriPengajuan->delete();

        return back()->with('success', 'Kategori pengumpulan data berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);
    }
}
