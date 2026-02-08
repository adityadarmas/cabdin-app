<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class PimpinanController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with(['tamu', 'user'])
            ->latest()
            ->paginate(10);

        return view('users.pimpinan.dashboard.index', compact('suratMasuk'));
    }

    // DETAIL + FORM DISPOSISI
    public function show(SuratMasuk $suratMasuk)
    {
        $staff = User::where('role', 'staff')->get();

        return view('users.pimpinan.dashboard.show', compact('suratMasuk', 'staff'));
    }

    // UPDATE KHUSUS PIMPINAN
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'tgl_kegiatan' => 'nullable|date',
            'user_id'      => 'nullable|exists:users,id',
            'disposisi'    => 'nullable|string'
        ]);

        $suratMasuk->update($validated);

        return redirect()
            ->route('pimpinan.show', $suratMasuk->id)
            ->with('success', 'Disposisi berhasil disimpan');
    }
}
