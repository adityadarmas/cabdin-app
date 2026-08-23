<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index()
    {
        $panduans = Panduan::orderBy('urutan')->latest()->paginate(15);
        return view('dashboard.panduan.index', compact('panduans'));
    }

    public function create()
    {
        return view('dashboard.panduan.form', ['panduan' => new Panduan(['tipe' => 'artikel', 'urutan' => 1, 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        Panduan::create($this->validated($request));
        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil ditambahkan.');
    }

    public function edit(Panduan $panduan)
    {
        return view('dashboard.panduan.form', compact('panduan'));
    }

    public function update(Request $request, Panduan $panduan)
    {
        $panduan->update($this->validated($request));
        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil diperbarui.');
    }

    public function destroy(Panduan $panduan)
    {
        $panduan->delete();
        return back()->with('success', 'Panduan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:artikel,video',
            'konten' => 'nullable|string|max:10000|required_if:tipe,artikel',
            'video_url' => 'nullable|url|max:1000|required_if:tipe,video',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);
    }
}
