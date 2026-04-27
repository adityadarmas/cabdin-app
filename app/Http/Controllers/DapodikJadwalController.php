<?php

namespace App\Http\Controllers;

use App\Models\DapodikJadwal;
use Illuminate\Http\Request;

class DapodikJadwalController extends Controller
{
    public function edit(string $jenis)
    {
        abort_unless(in_array($jenis, ['edit_ptk', 'tambah_ptk']), 404);

        $jadwal = DapodikJadwal::firstOrNew(['jenis' => $jenis]);

        return view('dashboard.dapodik_jadwal.edit', compact('jadwal', 'jenis'));
    }

    public function update(Request $request, string $jenis)
    {
        abort_unless(in_array($jenis, ['edit_ptk', 'tambah_ptk']), 404);

        $validated = $request->validate([
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        DapodikJadwal::updateOrCreate(
            ['jenis' => $jenis],
            $validated
        );

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Jadwal ' . DapodikJadwal::JENIS_LABEL[$jenis] . ' berhasil diperbarui');
    }
}
