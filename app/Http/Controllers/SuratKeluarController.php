<?php

namespace App\Http\Controllers;

use App\Models\NomorSuratSetting;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::with('user')->latest()->paginate(15);
        return view('surat_keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        return view('surat_keluar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_surat'    => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        $validated['nomor_surat'] = NomorSuratSetting::generateNext();
        $validated['user_id']     = auth()->id();

        SuratKeluar::create($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dicatat.');
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        $this->authorize('update', $suratKeluar);
        return view('surat_keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $this->authorize('update', $suratKeluar);

        $validated = $request->validate([
            'judul_surat'    => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        $suratKeluar->update($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        $this->authorize('delete', $suratKeluar);

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}
