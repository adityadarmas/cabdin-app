<?php

namespace App\Http\Controllers;

use App\Models\DapodikJadwal;
use App\Models\KategoriProsedur;
use App\Models\Prosedur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProsedurController extends Controller
{
    public function index()
    {
        $kategori = KategoriProsedur::orderBy('urutan')
            ->with(['prosedurs'])
            ->get();

        $dapodikJadwals = DapodikJadwal::whereIn('jenis', ['edit_ptk', 'tambah_ptk'])
            ->get()
            ->keyBy('jenis');

        return view('dashboard.prosedur.index', compact('kategori', 'dapodikJadwals'));
    }

    public function show(Prosedur $prosedur)
    {
        $prosedur->load('kategori');

        $related = Prosedur::where('is_active', true)
            ->where('id', '!=', $prosedur->id)
            ->where('kategori_id', $prosedur->kategori_id)
            ->orderBy('urutan')
            ->limit(5)
            ->get();

        return view('prosedur.show', compact('prosedur', 'related'));
    }

    public function category(KategoriProsedur $kategoriProsedur)
    {
        abort_unless($kategoriProsedur->is_active, 404);

        $kategoriProsedur->load('prosedursAktif');
        $dapodikJadwals = collect();

        if (str_contains(strtolower($kategoriProsedur->nama), 'dapodik')) {
            $dapodikJadwals = DapodikJadwal::whereIn('jenis', ['edit_ptk', 'tambah_ptk'])
                ->get()
                ->keyBy('jenis');
        }

        return view('prosedur.category', compact('kategoriProsedur', 'dapodikJadwals'));
    }

    public function create()
    {
        $kategori = KategoriProsedur::where('is_active', true)->orderBy('urutan')->get();
        return view('dashboard.prosedur.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_prosedurs,id',
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan'      => 'required|integer|min:1',
            'is_active'   => 'required|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('prosedur', 'public');
        }

        Prosedur::create($validated);

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Prosedur berhasil ditambahkan');
    }

    public function edit(Prosedur $prosedur)
    {
        $kategori = KategoriProsedur::where('is_active', true)->orderBy('urutan')->get();
        return view('dashboard.prosedur.edit', compact('prosedur', 'kategori'));
    }

    public function update(Request $request, Prosedur $prosedur)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_prosedurs,id',
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan'      => 'required|integer|min:1',
            'is_active'   => 'required|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($prosedur->thumbnail) {
                Storage::disk('public')->delete($prosedur->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('prosedur', 'public');
        }

        $prosedur->update($validated);

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Prosedur berhasil diperbarui');
    }

    public function destroy(Prosedur $prosedur)
    {
        if ($prosedur->thumbnail) {
            Storage::disk('public')->delete($prosedur->thumbnail);
        }

        $prosedur->delete();

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Prosedur berhasil dihapus');
    }
}
