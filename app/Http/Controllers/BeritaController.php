<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriInformasi;
use App\Models\User;
use App\Notifications\BeritaPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::with('kategoriInformasi')->latest()->get();
        return view('dashboard.berita.index', compact('data'));
    }

    public function publicIndex(Request $request)
    {
        $query = Berita::with('kategoriInformasi')->where('is_active', 1)->latest();
        if ($request->filled('kategori')) {
            $kategori = KategoriInformasi::find($request->integer('kategori'));
            if ($kategori) {
                $categoryIds = [$kategori->id, ...$kategori->children()->pluck('id')->all()];
                $query->whereIn('kategori_informasi_id', $categoryIds);
            }
        }
        $berita = $query->paginate(9)->withQueryString();
        $kategoriInformasis = KategoriInformasi::where('is_active', true)->orderBy('urutan')->get();
        return view('berita.index', compact('berita', 'kategoriInformasis'));
    }

    public function show(Berita $berita)
    {
        $related = Berita::where('is_active', 1)
            ->where('id', '!=', $berita->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('berita.show', compact('berita', 'related'));
    }

    public function create()
    {
        return view('dashboard.berita.create', ['kategoriInformasis' => $this->categories()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_informasi_id' => 'nullable|exists:kategori_informasi,id',
            'judul'     => 'required|string|max:255',
            'konten'    => 'required',
            'tanggal'   => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('berita', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        $berita = Berita::create($validated)->refresh();

        if ($berita->is_active) {
            Notification::send(
                User::where('role', 'operator')->get(),
                new BeritaPublished($berita)
            );
        }

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(Berita $berita)
    {
        return view('dashboard.berita.edit', ['berita' => $berita, 'kategoriInformasis' => $this->categories()]);
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'kategori_informasi_id' => 'nullable|exists:kategori_informasi,id',
            'judul'   => 'required|string|max:255',
            'konten'  => 'required',
            'tanggal' => 'required|date',
        ]);

        $berita->update($validated);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil dihapus');
    }

    private function categories()
    {
        return KategoriInformasi::where('is_active', true)->orderBy('urutan')->get();
    }
}
