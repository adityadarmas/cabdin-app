<?php

namespace App\Http\Controllers;

use App\Models\KategoriProsedur;
use Illuminate\Http\Request;

class KategoriProsedurController extends Controller
{
    public function index()
    {
        $data = KategoriProsedur::orderBy('urutan')->withCount('prosedurs')->get();
        return view('dashboard.kategori_prosedur.index', compact('data'));
    }

    public function create()
    {
        return view('dashboard.kategori_prosedur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'urutan'    => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        KategoriProsedur::create($validated);

        return redirect()
            ->route('kategori-prosedur.index')
            ->with('success', 'Kategori prosedur berhasil ditambahkan');
    }

    public function edit(KategoriProsedur $kategoriProsedur)
    {
        return view('dashboard.kategori_prosedur.edit', compact('kategoriProsedur'));
    }

    public function update(Request $request, KategoriProsedur $kategoriProsedur)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'urutan'    => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $kategoriProsedur->update($validated);

        return redirect()
            ->route('kategori-prosedur.index')
            ->with('success', 'Kategori prosedur berhasil diperbarui');
    }

    public function destroy(KategoriProsedur $kategoriProsedur)
    {
        $kategoriProsedur->delete();

        return redirect()
            ->route('kategori-prosedur.index')
            ->with('success', 'Kategori prosedur berhasil dihapus');
    }
}
