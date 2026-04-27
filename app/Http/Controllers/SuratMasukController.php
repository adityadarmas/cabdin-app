<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Tamu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    /**
     * LIST SURAT MASUK
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', SuratMasuk::class);

        $user   = auth()->user();
        $search = $request->input('search');

        if ($user->role === 'staff') {
            $query = SuratMasuk::whereHas('penerima', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with(['penerima' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }, 'tamu']);
        } elseif ($user->role === 'pimpinan') {
            $query = SuratMasuk::with('penerima', 'tamu')
                ->whereNotIn('status', ['diterima']);
        } else {
            $query = SuratMasuk::with('penerima', 'tamu');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('perihal', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%")
                  ->orWhereHas('tamu', fn($q2) => $q2->where('nama', 'like', "%{$search}%"));
            });
        }

        $suratMasuk = $query->latest()->paginate(10)->withQueryString();

        return view('surat_masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        $this->authorize('create', SuratMasuk::class);

        $tamu = Tamu::all();
        return view('surat_masuk.create', compact('tamu'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', SuratMasuk::class);

        $isDisposisi = $request->boolean('is_disposisi');

        if ($isDisposisi) {
            // Fallback: disposisi form uses separate field names before JS sync
            if (!$request->filled('tamu_id') && $request->filled('tamu_id_disposisi')) {
                $request->merge(['tamu_id' => $request->tamu_id_disposisi]);
            }
            if (!$request->filled('tgl_diterima') && $request->filled('tgl_diterima_disposisi')) {
                $request->merge(['tgl_diterima' => $request->tgl_diterima_disposisi]);
            }

            $validated = $request->validate([
                'tamu_id'       => 'required|exists:tamu,id',
                'nomor_surat'   => 'required|unique:surat_masuk',
                'perihal'       => 'required',
                'tgl_surat'     => 'required|date',
                'tgl_diterima'  => 'required|date',
                'nomor_agenda'  => 'nullable|string|max:100',
                'ringkasan'     => 'nullable|string',
                'filepath'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);
            $validated['is_disposisi'] = true;
            $validated['status'] = 'diterima';
        } else {
            $validated = $request->validate([
                'tamu_id'      => 'required|exists:tamu,id',
                'perihal'      => 'required|string|max:255',
                'tgl_diterima' => 'required|date',
                'jenis'        => 'required',
                'keterangan'   => 'nullable|string',
                'ringkasan'    => 'nullable|string',
                'filepath'     => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);
            $validated['is_disposisi'] = false;
            $validated['status'] = 'diterima';
            $validated['nomor_surat'] = 'NON-' . now()->format('YmdHis');
        }

        if ($request->hasFile('filepath')) {
            $validated['filepath'] = $request->file('filepath')
                ->store('surat_masuk', 'public');
        }

        $validated['user_id'] = null;

        $surat = SuratMasuk::create($validated);

        $surat->generateTrackingToken();

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan');
    }

    public function generateToken(SuratMasuk $suratMasuk)
    {
        $this->authorize('update', $suratMasuk);
        
        $suratMasuk->generateTrackingToken();

        return back()->with('success', 'Link tracking berhasil dibuat');
    }

    /**
     * DETAIL SURAT
     * TU, PIMPINAN, STAFF
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $this->authorize('view', $suratMasuk);

        $staff = User::where('role', 'staff')->get();
        
        // Load relasi penerima untuk ditampilkan
        $suratMasuk->load('penerima', 'tamu');
        
        // Cek apakah user yang login adalah staff penerima
        $user = auth()->user();
        $isStaffPenerima = false;
        $statusDisposisi = null;
        
        if ($user->role === 'staff') {
            $penerima = $suratMasuk->penerima->where('id', $user->id)->first();
            if ($penerima) {
                $isStaffPenerima = true;
                $statusDisposisi = $penerima->pivot->status;
                
                // Update status menjadi 'dibaca' jika masih 'pending'
                if ($statusDisposisi === 'pending') {
                    $suratMasuk->penerima()->updateExistingPivot($user->id, [
                        'status' => 'dibaca',
                        'tanggal_dibaca' => now()
                    ]);
                    $statusDisposisi = 'dibaca';
                }
            }
        }
        
        return view('surat_masuk.show', compact('suratMasuk', 'staff', 'isStaffPenerima', 'statusDisposisi'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $this->authorize('update', $suratMasuk);

        $tamu = Tamu::all();
        return view('surat_masuk.edit', compact('suratMasuk', 'tamu'));
    }

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
     * DISPOSISI SURAT - DIPERBAIKI UNTUK BANYAK STAFF
     */
    public function disposisi(Request $request, SuratMasuk $suratMasuk)
    {
        $this->authorize('disposisi', $suratMasuk);

        $validated = $request->validate([
            'tgl_kegiatan'   => 'nullable|date',
            'sifat_dispo'    => 'nullable|in:sangat_segera,segera,rahasia',
            'staff_ids'      => 'required|array|min:1', // UBAH: terima array
            'staff_ids.*'    => 'exists:users,id',
            'filepath'       => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'disposisi'      => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('filepath')) {
                if ($suratMasuk->filepath) {
                    Storage::disk('public')->delete($suratMasuk->filepath);
                }

                $validated['filepath'] = $request->file('filepath')
                    ->store('surat_masuk', 'public');
            }

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

            // Update data surat + tandai status disposisi
            $suratMasuk->update([
                'disposisi'            => $request->disposisi,
                'tgl_kegiatan'         => $request->tgl_kegiatan,
                'sifat_dispo'          => $request->sifat_dispo,
                'dengan_hormat_harap'  => $validated['dengan_hormat_harap'] ?? $suratMasuk->dengan_hormat_harap,
                'filepath'             => $validated['filepath'] ?? $suratMasuk->filepath,
                'status'               => 'disposisi',
            ]);

            // TODO: Fitur penerusan ke staff sementara dinonaktifkan.
            // Aktifkan kembali blok di bawah ini ketika fitur siap digunakan.
            // $suratMasuk->penerima()->detach();
            // $suratMasuk->penerima()->attach($request->staff_ids, [
            //     'status' => 'pending',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

            DB::commit();

            return redirect()
                ->route('surat-masuk.index')
                ->with('success', 'Disposisi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal mengirim disposisi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * TU mengirim surat ke pimpinan → status: dikirim
     */
    public function kirim(SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'tu') {
            abort(403);
        }

        if ($suratMasuk->status !== 'diterima') {
            return back()->with('error', 'Surat hanya bisa dikirim saat berstatus Diterima.');
        }

        $suratMasuk->update([
            'status'      => 'dikirim',
            'tgl_dikirim' => now(),
        ]);

        return back()->with('success', 'Surat berhasil dikirim ke pimpinan.');
    }

    /**
     * Pimpinan menyetujui surat → status: disetujui
     */
    public function setujui(SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'pimpinan') {
            abort(403);
        }

        if ($suratMasuk->status !== 'dikirim') {
            return back()->with('error', 'Surat hanya bisa disetujui saat berstatus Dikirim.');
        }

        $suratMasuk->update([
            'status'        => 'disetujui',
            'tgl_disetujui' => now(),
        ]);

        return back()->with('success', 'Surat berhasil disetujui.');
    }

    /**
     * TU menandai surat selesai (siap diambil) + catat nama pengambil → status: siap_diambil
     */
    public function selesai(Request $request, SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'tu') {
            abort(403);
        }

        if ($suratMasuk->status !== 'disetujui') {
            return back()->with('error', 'Surat hanya bisa diselesaikan saat berstatus Disetujui.');
        }

        $validated = $request->validate([
            'nama_pengambil' => 'required|string|max:255',
        ]);

        $suratMasuk->update([
            'status'           => 'siap_diambil',
            'tgl_siap_diambil' => now(),
            'nama_pengambil'   => $validated['nama_pengambil'],
        ]);

        return back()->with('success', 'Surat telah selesai dan siap diambil.');
    }

    /**
     * Tampilkan halaman cetak kitir (hanya TU)
     */
    public function kitir(SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'tu') {
            abort(403);
        }

        $suratMasuk->load('tamu');

        // Jika kitir_isi belum pernah diisi, generate default dari template jenis surat
        if (empty($suratMasuk->kitir_isi)) {
            $suratMasuk->kitir_isi = $this->generateKitirTemplate($suratMasuk);
        }

        $kitirTemplates = $this->kitirTemplates($suratMasuk);

        return view('surat_masuk.kitir', compact('suratMasuk', 'kitirTemplates'));
    }

    private function generateKitirTemplate(SuratMasuk $surat): string
    {
        $templates = $this->kitirTemplates($surat);
        return $templates[$surat->jenis] ?? $templates['_default'];
    }

    private function kitirTemplates(SuratMasuk $surat): array
    {
        $asal    = $surat->asal ?: ($surat->tamu->nama ?? '-');
        $perihal = $surat->perihal ?? '-';
        $nomor   = $surat->nomor_surat ?? '-';
        $tgl     = $surat->tgl_diterima ? $surat->tgl_diterima->format('d/m/Y') : '-';

        return [
            'mutasi' => implode("\n", [
                "Surat Mutasi",
                "Dari       : {$asal}",
                "No. Surat  : {$nomor}",
                "Perihal    : {$perihal}",
                "",
                "Mohon diproses sesuai ketentuan yang berlaku.",
            ]),
            'izin_penelitian' => implode("\n", [
                "Surat Izin Penelitian",
                "Dari       : {$asal}",
                "No. Surat  : {$nomor}",
                "Perihal    : {$perihal}",
                "",
                "Mohon ditindaklanjuti dan diarsipkan.",
            ]),
            'pemberitahuan' => implode("\n", [
                "Surat Pemberitahuan",
                "Dari       : {$asal}",
                "No. Surat  : {$nomor}",
                "Perihal    : {$perihal}",
            ]),
            '_default' => implode("\n", [
                "Dari       : {$asal}",
                "No. Surat  : {$nomor}",
                "Perihal    : {$perihal}",
                "Tgl Terima : {$tgl}",
            ]),
        ];
    }

    /**
     * Simpan isi kitir (hanya TU)
     */
    public function updateKitir(Request $request, SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'tu') {
            abort(403);
        }

        $validated = $request->validate([
            'kitir_isi' => 'required|string|max:1000',
        ]);

        $suratMasuk->update($validated);

        return back()->with('success', 'Isi kitir berhasil disimpan. Silakan cetak.');
    }

    /**
     * Halaman cetak lembar disposisi (TU/admin, setelah pimpinan mengisi form disposisi)
     */
    public function disposisiCetak(SuratMasuk $suratMasuk)
    {
        if (!in_array(auth()->user()->role, ['tu', 'admin'])) {
            abort(403);
        }

        if (!$suratMasuk->is_disposisi) {
            abort(404, 'Surat ini bukan jenis disposisi.');
        }

        $suratMasuk->load('penerima', 'tamu');

        return view('surat_masuk.disposisi_cetak', compact('suratMasuk'));
    }

    /**
     * Cetak tanda terima surat masuk (hanya TU)
     */
    public function tandaTerima(SuratMasuk $suratMasuk)
    {
        if (auth()->user()->role !== 'tu') {
            abort(403);
        }

        $suratMasuk->load('tamu');

        if (!$suratMasuk->tracking_token) {
            $suratMasuk->generateTrackingToken();
        }

        return view('surat_masuk.tanda_terima', compact('suratMasuk'));
    }

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

    /**
     * UPDATE STATUS DISPOSISI OLEH STAFF
     */
    public function updateStatus(Request $request, SuratMasuk $suratMasuk)
    {
        $user = auth()->user();
        
        if ($user->role !== 'staff') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => 'required|in:dibaca,selesai'
        ]);

        $suratMasuk->penerima()->updateExistingPivot($user->id, [
            'status' => $validated['status'],
            'tanggal_selesai' => $validated['status'] === 'selesai' ? now() : null
        ]);

        return redirect()
            ->route('surat-masuk.show', $suratMasuk)
            ->with('success', 'Status disposisi berhasil diperbarui');
    }

    
}