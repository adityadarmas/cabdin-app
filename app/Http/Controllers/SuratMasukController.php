<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Tamu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    /**
     * LIST SURAT MASUK
     * TU, PIMPINAN, STAFF
     */
    public function index()
    {
        $this->authorize('viewAny', SuratMasuk::class);

        $user = auth()->user();

        if ($user->role === 'staff') {
            $suratMasuk = SuratMasuk::where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } elseif ($user->role === 'pimpinan') {
            $suratMasuk = SuratMasuk::whereNotNull('tgl_kegiatan')
                ->latest()
                ->paginate(10);
        } else {
            // TU
            $suratMasuk = SuratMasuk::latest()->paginate(10);
        }

        // ===== DATA KALENDER =====
        $events = $suratMasuk->map(function ($surat) {
            return [
                'title' => $surat->perihal,
                'date'  => Carbon::parse($surat->tgl_kegiatan)->format('Y-m-d'),
                'url'   => route('surat-masuk.show', $surat),
            ];
        });

        return view('surat_masuk.index', compact('suratMasuk', 'events'));
    }

    /**
     * FORM TAMBAH SURAT
     * KHUSUS TU
     */
    public function create()
    {
        $this->authorize('create', SuratMasuk::class);

        $tamu = Tamu::all();
        return view('surat_masuk.create', compact('tamu'));
    }

    /**
     * SIMPAN SURAT
     * KHUSUS TU
     */
    public function store(Request $request)
    {
        $this->authorize('create', SuratMasuk::class);

        $validated = $request->validate([
            'nomor_surat'   => 'required|unique:surat_masuk',
            'perihal'       => 'required',
            'asal'          => 'required',
            'tgl_diterima'  => 'required|date',
            'tgl_kegiatan'  => 'nullable|date',
            'sifat'         => 'nullable',
            'jenis'         => 'nullable',
            'filepath'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tamu_id'       => 'nullable|exists:tamu,id',
        ]);

        $validated['status']  = 'diterima';
        $validated['user_id'] = null; // BELUM didisposisi

        if ($request->hasFile('filepath')) {
            $validated['filepath'] = $request->file('filepath')
                ->store('surat_masuk', 'public');
        }

        SuratMasuk::create($validated);

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan');
    }

    /**
     * DETAIL SURAT
     * TU, PIMPINAN, STAFF
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $this->authorize('view', $suratMasuk);

        $staff = User::where('role', 'staff')->get();
        return view('surat_masuk.show', compact('suratMasuk', 'staff'));
    }

    /**
     * FORM EDIT
     * KHUSUS TU
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        $this->authorize('update', $suratMasuk);

        $tamu = Tamu::all();
        return view('surat_masuk.edit', compact('suratMasuk', 'tamu'));
    }

    /**
     * UPDATE DATA SURAT
     * TU
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $this->authorize('update', $suratMasuk);

        $validated = $request->validate([
            'nomor_surat'   => 'sometimes|required|unique:surat_masuk,nomor_surat,' . $suratMasuk->id,
            'perihal'       => 'sometimes|required',
            'asal'          => 'sometimes|required',
            'tgl_diterima'  => 'sometimes|required|date',
            'tgl_kegiatan'  => 'nullable|date',
            'sifat'         => 'nullable',
            'jenis'         => 'nullable',
            'filepath'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tamu_id'       => 'nullable|exists:tamu,id',
            'sifat_dispo'   => 'nullable|in:sangat_segera,segera,rahasia',
        ]);

        if ($request->hasFile('filepath')) {
            if ($suratMasuk->filepath) {
                Storage::disk('public')->delete($suratMasuk->filepath);
            }

            $validated['filepath'] = $request->file('filepath')
                ->store('surat_masuk', 'public');
        }

        // ===== DENGAN HORMAT HARAP =====
        $pilihan = $request->harap_pilihan
            ? implode(', ', $request->harap_pilihan)
            : '';

        $keterangan = trim($request->harap_keterangan ?? '');

        if ($pilihan || $keterangan) {
            $validated['dengan_hormat_harap'] =
                $pilihan && $keterangan
                    ? "{$pilihan} | {$keterangan}"
                    : ($pilihan ?: $keterangan);
        }

        $suratMasuk->update($validated);

        return redirect()
            ->route('surat-masuk.show', $suratMasuk->id)
            ->with('success', 'Surat berhasil diperbarui');
    }

    /**
     * DISPOSISI SURAT
     * KHUSUS PIMPINAN (SINGLE STAFF)
     */
    public function disposisi(Request $request, SuratMasuk $suratMasuk)
    {
        $this->authorize('disposisi', $suratMasuk);

        $validated = $request->validate([
            'tgl_kegiatan'  => 'nullable|date',
            'sifat_dispo'   => 'nullable|in:sangat_segera,segera,rahasia',
            'user_id'       => 'required|exists:users,id',
            'filepath'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'disposisi'     => 'nullable',
        ]);

        if ($request->hasFile('filepath')) {
            if ($suratMasuk->filepath) {
                Storage::disk('public')->delete($suratMasuk->filepath);
            }

            $validated['filepath'] = $request->file('filepath')
                ->store('surat_masuk', 'public');
        }

        // ===== DENGAN HORMAT HARAP =====
        $pilihan = $request->harap_pilihan
            ? implode(', ', $request->harap_pilihan)
            : '';

        $keterangan = trim($request->harap_keterangan ?? '');

        if ($pilihan || $keterangan) {
            $validated['dengan_hormat_harap'] =
                $pilihan && $keterangan
                    ? "{$pilihan} | {$keterangan}"
                    : ($pilihan ?: $keterangan);
        }

        // ===== UPDATE SURAT =====
        $suratMasuk->update([
            'user_id'              => $request->user_id,
            'disposisi'            => $request->disposisi,
            'tgl_kegiatan'         => $request->tgl_kegiatan,
            'sifat_dispo'          => $request->sifat_dispo,
            'dengan_hormat_harap'  => $validated['dengan_hormat_harap'] ?? $suratMasuk->dengan_hormat_harap,
            'filepath'             => $validated['filepath'] ?? $suratMasuk->filepath,
        ]);

        return redirect()
            // ->route('surat-masuk.show', $suratMasuk->id)
            ->route('surat-masuk.index')
            ->with('success', 'Disposisi berhasil dikirim ke staff');
    }

    /**
     * HAPUS SURAT
     * KHUSUS TU
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        $this->authorize('delete', $suratMasuk);

        if ($suratMasuk->filepath) {
            Storage::disk('public')->delete($suratMasuk->filepath);
        }

        $suratMasuk->delete();

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat berhasil dihapus');
    }
}
