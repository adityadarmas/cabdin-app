<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat = SuratKeluar::latest()->get();
        return view('surat_keluar.index', compact('surat'));
    }

    public function create()
    {
        return view('surat_keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required',
            'perihal' => 'required',
            'isi_surat' => 'required',
        ]);

        SuratKeluar::create([
            'user_id' => Auth::id(),
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'isi_surat' => $request->isi_surat,
            'status' => 'draft'
        ]);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Draft surat berhasil dibuat');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $this->authorize('view', $suratKeluar);
        return view('surat_keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        $this->authorize('update', $suratKeluar);
        return view('surat_keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $this->authorize('update', $suratKeluar);

        $suratKeluar->update($request->only('tujuan','perihal','isi_surat'));

        return redirect()->route('surat-keluar.index');
    }

    public function ajukan(SuratKeluar $suratKeluar)
    {
        $this->authorize('ajukan', $suratKeluar);

        $suratKeluar->update([
            'status' => 'menunggu_persetujuan'
        ]);

        return back()->with('success', 'Surat diajukan ke pimpinan');
    }

    public function setujui(SuratKeluar $suratKeluar)
    {
        $this->authorize('approve', $suratKeluar);

        $suratKeluar->update([
            'status' => 'disetujui',
            'nomor_surat' => $this->generateNomor(),
            'tanggal_disetujui' => now()
        ]);

        return back();
    }

    protected function generateNomor()
    {
        $last = SuratKeluar::whereNotNull('nomor_surat')->count() + 1;
        return str_pad($last, 3, '0', STR_PAD_LEFT)
            . '/SK/' . now()->format('m/Y');
    }
}
