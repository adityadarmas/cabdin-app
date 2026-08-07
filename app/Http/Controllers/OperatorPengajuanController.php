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
        $pengajuans = Pengajuan::with('jenisPengajuan')->where('user_id', auth()->id())->latest()->paginate(10);
        $jenisPengajuans = $this->activeTypes();
        return view('operator.pengajuan.index', compact('pengajuans', 'jenisPengajuans'));
    }

    public function create(Request $request)
    {
        $pengajuan = new Pengajuan(['jenis_pengajuan_id' => $request->integer('jenis')]);
        return view('operator.pengajuan.form', compact('pengajuan') + ['jenisPengajuans' => $this->activeTypes()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['user_id'] = auth()->id();
        $data['status'] = 'menunggu';
        $data['submitted_at'] = now();
        $data['lampiran'] = $this->storeAttachment($request);
        Pengajuan::create($data);

        return redirect()->route('operator.pengajuan.index')->with('success', 'Pengajuan berhasil dikirim untuk ditinjau admin.');
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
        $data = $this->validateData($request);
        if ($request->hasFile('lampiran')) {
            if ($pengajuan->lampiran) {
                Storage::disk('public')->delete($pengajuan->lampiran);
            }
            $data['lampiran'] = $this->storeAttachment($request);
        }
        $data['status'] = 'menunggu';
        $data['submitted_at'] = now();
        $data['keterangan_admin'] = null;
        $pengajuan->update($data);

        return redirect()->route('operator.pengajuan.index')->with('success', 'Pengajuan diperbarui dan dikirim ulang ke admin.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        if ($pengajuan->lampiran) {
            Storage::disk('public')->delete($pengajuan->lampiran);
        }
        $pengajuan->delete();
        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        $rules = [
            'jenis_pengajuan_id' => 'required|exists:jenis_pengajuans,id',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'data_tambahan' => 'nullable|array',
        ];

        $jenis = JenisPengajuan::where('is_active', true)->findOrFail($request->integer('jenis_pengajuan_id'));
        $rules['judul'] = 'nullable';
        foreach ($jenis->form_fields ?? [] as $field) {
            $rule = [$field['required'] ? 'required' : 'nullable'];
            $rule[] = match ($field['type']) { 'number' => 'numeric', 'date' => 'date', default => 'string' };
            $rule[] = 'max:2000';
            $rules['data_tambahan.'.$field['key']] = $rule;
        }

        $data = $request->validate($rules);
        $data['judul'] = $jenis->nama;
        return $data;
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
        return JenisPengajuan::where('is_active', true)->orderBy('urutan')->get();
    }
}
