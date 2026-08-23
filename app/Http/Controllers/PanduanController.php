<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanduanController extends Controller
{
    public function index()
    {
        $panduans = Panduan::orderBy('urutan')->latest()->paginate(15);
        return view('dashboard.panduan.index', compact('panduans'));
    }

    public function create()
    {
        return view('dashboard.panduan.form', ['panduan' => new Panduan(['urutan' => 1, 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->storeFiles($request, $data);
        Panduan::create($data);
        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil ditambahkan.');
    }

    public function edit(Panduan $panduan)
    {
        return view('dashboard.panduan.form', compact('panduan'));
    }

    public function update(Request $request, Panduan $panduan)
    {
        $data = $this->validated($request);
        $this->storeFiles($request, $data, $panduan);
        $panduan->update($data);
        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil diperbarui.');
    }

    public function destroy(Panduan $panduan)
    {
        Storage::disk('public')->delete(array_filter([$panduan->gambar, $panduan->lampiran]));
        $panduan->delete();
        return back()->with('success', 'Panduan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string|max:10000',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);
    }

    private function storeFiles(Request $request, array &$data, ?Panduan $panduan = null): void
    {
        foreach (['gambar', 'lampiran'] as $field) {
            if ($request->hasFile($field)) {
                if ($panduan?->{$field}) Storage::disk('public')->delete($panduan->{$field});
                $data[$field] = $request->file($field)->store('panduan', 'public');
            }
        }
    }
}
