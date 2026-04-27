<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;

class TamuController extends Controller
{
    /**
     * Tampilkan daftar tamu sebelumnya
     */
    public function index()
    {
        $tamu = Tamu::latest()->paginate(10);
        return view('tamu.index', compact('tamu'));
    }

    /**
     * Form tambah tamu
     */
    public function create()
    {
        $tamu = Tamu::latest()->paginate(10);
        return view('tamu.create', compact('tamu'));
    }

    /**
     * Simpan data tamu baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'asal'     => 'required|string|max:255',
            'keperluan'=> 'required|string|max:255',
            'nomor_hp' => 'nullable|string|max:20',
        ]);

        Tamu::create([
            'nama'     => $request->nama,
            'asal'     => $request->asal,
            'keperluan'=> $request->keperluan,
            'nomor_hp' => $request->nomor_hp,
        ]);

        return redirect()
            ->route('tamu.create')
            ->with('success', 'Selamat datang di Cabdin Kab. Malang, semoga keperluan Anda terbantu.');
    }

    /**
     * Form edit data tamu
     */
    public function edit(Tamu $tamu)
    {
        return view('tamu.edit', compact('tamu'));
    }

    /**
     * Update data tamu
     */
    public function update(Request $request, Tamu $tamu)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'asal'     => 'required|string|max:255',
            'keperluan'=> 'required|string|max:255',
            'nomor_hp' => 'nullable|string|max:20',
        ]);

        $tamu->update([
            'nama'     => $request->nama,
            'asal'     => $request->asal,
            'keperluan'=> $request->keperluan,
            'nomor_hp' => $request->nomor_hp,
        ]);

        return redirect()
            ->route('tamu.index')
            ->with('success', 'Data tamu berhasil diperbarui');
    }
}
