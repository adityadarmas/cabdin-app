<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::latest()->get();
        return view('dashboard.berita.index', compact('data'));
    }

    public function publicIndex()
    {
        $berita = Berita::where('is_active', 1)->latest()->paginate(9);
        return view('berita.index', compact('berita'));
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
        return view('dashboard.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        Berita::create($validated);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(Berita $berita)
    {
        return view('dashboard.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
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
}
