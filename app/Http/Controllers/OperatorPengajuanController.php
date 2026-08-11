<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\JenisPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OperatorPengajuanController extends Controller
{
    public function index()
    {
        $jenisPengajuans = $this->activeTypes();
        $user = auth()->user();
        $notifikasi = $user->unreadNotifications()->latest()->limit(5)->get();
        $user->unreadNotifications()->update(['read_at' => now()]);

        return view('operator.pengajuan.index', compact('jenisPengajuans', 'notifikasi'));
    }

    public function jenis(JenisPengajuan $jenisPengajuan)
    {
        abort_unless($jenisPengajuan->is_active, 404);

        $pengajuans = Pengajuan::where('user_id', auth()->id())
            ->where('jenis_pengajuan_id', $jenisPengajuan->id)
            ->latest('submitted_at')
            ->paginate(10);

        return view('operator.pengajuan.jenis', compact('jenisPengajuan', 'pengajuans'));
    }

    public function show(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $pengajuan->load('jenisPengajuan');

        return view('operator.pengajuan.show', compact('pengajuan'));
    }

    public function create(Request $request)
    {
        $pengajuan = new Pengajuan(['jenis_pengajuan_id' => $request->integer('jenis')]);
        return view('operator.pengajuan.form', compact('pengajuan') + ['jenisPengajuans' => $this->activeTypes()]);
    }

    public function store(Request $request)
    {
        $jenis = $this->selectedJenis($request);
        $data = $this->validateData($request, $jenis);
        $data['user_id'] = auth()->id();
        $data['status'] = 'menunggu';
        $data['submitted_at'] = now();
        $data['lampiran'] = $jenis->is_lampiran_enabled ? $this->storeAttachment($request) : null;
        Pengajuan::create($data);

        return redirect()->route('operator.pengajuan.jenis', $data['jenis_pengajuan_id'])->with('success', 'Pengumpulan data berhasil dikirim untuk ditinjau admin.');
    }

    public function edit(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        abort_unless(in_array($pengajuan->status, ['menunggu', 'ditolak']), 403);
        return view('operator.pengajuan.form', ['pengajuan' => $pengajuan, 'jenisPengajuans' => $this->activeTypes()]);
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        abort_unless(in_array($pengajuan->status, ['menunggu', 'ditolak']), 403);
        $jenis = $this->selectedJenis($request);
        $data = $this->validateData($request, $jenis);
        if ($jenis->is_lampiran_enabled && $request->hasFile('lampiran')) {
            if ($pengajuan->lampiran) {
                Storage::disk('public')->delete($pengajuan->lampiran);
            }
            $data['lampiran'] = $this->storeAttachment($request);
        }
        $data['status'] = 'menunggu';
        $data['submitted_at'] = now();
        $data['keterangan_admin'] = null;
        $pengajuan->update($data);

        return redirect()->route('operator.pengajuan.jenis', $data['jenis_pengajuan_id'])->with('success', 'Pengumpulan data diperbarui dan dikirim ulang ke admin.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        if ($pengajuan->lampiran) {
            Storage::disk('public')->delete($pengajuan->lampiran);
        }
        $pengajuan->delete();
        return back()->with('success', 'Pengumpulan data berhasil dihapus.');
    }

    private function validateData(Request $request, JenisPengajuan $jenis): array
    {
        $rules = [
            'jenis_pengajuan_id' => 'required|exists:jenis_pengajuans,id',
            'data_tambahan' => 'nullable|array',
        ];

        $rules['isi'] = $jenis->is_keterangan_enabled ? 'required|string' : 'nullable|string';
        if ($jenis->is_lampiran_enabled) {
            $rules['lampiran'] = 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120';
        }
        $rules['judul'] = 'nullable';
        foreach ($jenis->form_fields ?? [] as $field) {
            $rule = [$field['required'] ? 'required' : 'nullable'];
            $rule[] = match ($field['type']) { 'number' => 'numeric', 'date' => 'date', default => 'string' };
            $rule[] = 'max:2000';
            $rules['data_tambahan.'.$field['key']] = $rule;
        }

        $data = $request->validate($rules);
        $data['judul'] = $jenis->nama;
        $data['isi'] = $data['isi'] ?? '';
        return $data;
    }

    private function selectedJenis(Request $request): JenisPengajuan
    {
        return JenisPengajuan::where('is_active', true)
            ->findOrFail($request->integer('jenis_pengajuan_id'));
    }

    private function storeAttachment(Request $request): ?string
    {
        return $request->hasFile('lampiran') ? $request->file('lampiran')->store('pengajuan', 'public') : null;
    }

    private function authorizeOwner(Pengajuan $pengajuan): void
    {
        abort_unless($pengajuan->user_id === auth()->id(), 403);
    }

    private function activeTypes()
    {
        return JenisPengajuan::with('kategoriPengajuan')
            ->where('is_active', true)
            ->whereHas('kategoriPengajuan', fn ($query) => $query->where('is_active', true))
            ->orderBy('urutan')
            ->get()
            ->sortBy(fn (JenisPengajuan $jenis) => (($jenis->kategoriPengajuan?->urutan ?? 9999) * 10000) + $jenis->urutan)
            ->values();
    }
}
