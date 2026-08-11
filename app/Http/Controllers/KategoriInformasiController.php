<?php

namespace App\Http\Controllers;

use App\Models\KategoriInformasi;
use Illuminate\Http\Request;

class KategoriInformasiController extends Controller
{
    public function index()
    {
        $kategoriInformasis = KategoriInformasi::with(['parent', 'children'])->withCount(['informasis', 'children'])->orderBy('urutan')->get();
        return view('dashboard.kategori_informasi.index', compact('kategoriInformasis'));
    }
    public function store(Request $request)
    {
        KategoriInformasi::create($this->validated($request));
        return back()->with('success', 'Kategori informasi berhasil disimpan.');
    }
    public function update(Request $request, KategoriInformasi $kategoriInformasi)
    {
        $data = $this->validated($request);
        if (($data['parent_id'] ?? null) === $kategoriInformasi->id) return back()->with('error', 'Kategori tidak dapat menjadi induk dirinya sendiri.');
        $kategoriInformasi->update($data);
        return back()->with('success', 'Kategori informasi berhasil diperbarui.');
    }
    public function destroy(KategoriInformasi $kategoriInformasi)
    {
        if ($kategoriInformasi->informasis()->exists() || $kategoriInformasi->children()->exists()) return back()->with('error', 'Kategori yang masih memiliki informasi atau subkategori tidak dapat dihapus.');
        $kategoriInformasi->delete();
        return back()->with('success', 'Kategori informasi berhasil dihapus.');
    }
    private function validated(Request $request): array
    {
        return $request->validate(['nama'=>'required|string|max:100','parent_id'=>'nullable|exists:kategori_informasi,id','urutan'=>'required|integer|min:1','is_active'=>'required|boolean']);
    }
}
