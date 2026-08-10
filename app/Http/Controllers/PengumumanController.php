<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest('published_at')->latest()->paginate(15);

        return view('dashboard.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('dashboard.pengumuman.form', ['pengumuman' => new Pengumuman(['is_active' => true, 'published_at' => now()])]);
    }

    public function store(Request $request)
    {
        Pengumuman::create($this->validated($request));

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('dashboard.pengumuman.form', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $pengumuman->update($this->validated($request));

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:5000',
            'is_active' => 'required|boolean',
            'published_at' => 'nullable|date',
        ]);
    }
}
