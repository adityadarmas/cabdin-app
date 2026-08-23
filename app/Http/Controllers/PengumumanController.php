<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $this->validated($request);
        $this->storeFiles($request, $data);
        Pengumuman::create($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('dashboard.pengumuman.form', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $this->validated($request);
        $this->storeFiles($request, $data, $pengumuman);
        $pengumuman->update($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        Storage::disk('public')->delete(array_filter([$pengumuman->gambar, $pengumuman->lampiran]));
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
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);
    }

    private function storeFiles(Request $request, array &$data, ?Pengumuman $pengumuman = null): void
    {
        foreach (['gambar', 'lampiran'] as $field) {
            if ($request->hasFile($field)) {
                if ($pengumuman?->{$field}) Storage::disk('public')->delete($pengumuman->{$field});
                $data[$field] = $request->file($field)->store('pengumuman', 'public');
            }
        }
    }
}
