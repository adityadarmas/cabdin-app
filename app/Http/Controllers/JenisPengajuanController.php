<?php

namespace App\Http\Controllers;

use App\Models\JenisPengajuan;
use App\Models\KategoriPengajuan;
use App\Models\User;
use App\Notifications\TagihanBaru;
use Illuminate\Http\Request;

class JenisPengajuanController extends Controller
{
    public function index()
    {
        $jenisPengajuans = JenisPengajuan::with('kategoriPengajuan')->withCount('pengajuans')->orderBy('urutan')->get();
        return view('dashboard.jenis_pengajuan.index', compact('jenisPengajuans'));
    }

    public function create()
    {
        return view('dashboard.jenis_pengajuan.form', ['jenisPengajuan' => new JenisPengajuan(), 'kategoriPengajuans' => $this->activeCategories()]);
    }

    public function store(Request $request)
    {
        $jenisPengajuan = JenisPengajuan::create($this->validated($request));
        if ($jenisPengajuan->is_active && $jenisPengajuan->is_tagihan_dashboard) {
            $this->notifyTargetedOperators($jenisPengajuan);
        }
        return redirect()->route('jenis-pengajuan.index')->with('success', 'Jenis pengumpulan data berhasil ditambahkan.');
    }

    public function edit(JenisPengajuan $jenisPengajuan)
    {
        return view('dashboard.jenis_pengajuan.form', ['jenisPengajuan' => $jenisPengajuan, 'kategoriPengajuans' => $this->activeCategories()]);
    }

    public function update(Request $request, JenisPengajuan $jenisPengajuan)
    {
        $jenisPengajuan->update($this->validated($request));
        return redirect()->route('jenis-pengajuan.index')->with('success', 'Jenis pengumpulan data berhasil diperbarui.');
    }

    public function destroy(JenisPengajuan $jenisPengajuan)
    {
        if ($jenisPengajuan->pengajuans()->exists()) {
            return back()->with('error', 'Jenis pengumpulan data tidak dapat dihapus karena masih memiliki riwayat atau antrian data. Ubah status menjadi Nonaktif agar tidak dapat dipilih untuk pengumpulan data baru.');
        }

        $jenisPengajuan->delete();
        return back()->with('success', 'Jenis pengumpulan data berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_pengajuan_id' => 'required|exists:kategori_pengajuans,id',
            'deskripsi' => 'nullable|string|max:2000',
            'form_fields' => 'nullable|string',
            'urutan' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'is_keterangan_enabled' => 'required|boolean',
            'is_lampiran_enabled' => 'required|boolean',
            'is_tagihan_dashboard' => 'required|boolean',
            'deadline_at' => 'nullable|date',
            'target_bentuk_pendidikan' => 'required|in:semua,sma,smk',
            'target_status_sekolah' => 'required|in:semua,negeri,swasta',
        ]);
        $data['form_fields'] = $this->normaliseFields($data['form_fields'] ?? '');
        if ($data['is_tagihan_dashboard'] && empty($data['deadline_at'])) {
            throw \Illuminate\Validation\ValidationException::withMessages(['deadline_at' => 'Deadline wajib diisi untuk card tagihan.']);
        }
        return $data;
    }

    private function normaliseFields(string $fields): array
    {
        $decoded = json_decode($fields, true);
        if (!is_array($decoded)) return [];

        return collect($decoded)->map(function ($field) {
            $type = in_array($field['type'] ?? '', ['text', 'textarea', 'number', 'date', 'select']) ? $field['type'] : 'text';
            $key = preg_replace('/[^a-z0-9_]/', '_', strtolower($field['key'] ?? ''));
            return ['key' => trim($key, '_'), 'label' => trim($field['label'] ?? ''), 'type' => $type, 'required' => !empty($field['required']), 'options' => array_values(array_filter(array_map('trim', explode("\n", $field['options'] ?? ''))))];
        })->filter(fn ($field) => $field['key'] && $field['label'])->unique('key')->values()->all();
    }

    private function activeCategories()
    {
        return KategoriPengajuan::where('is_active', true)->orderBy('urutan')->get();
    }

    private function notifyTargetedOperators(JenisPengajuan $jenisPengajuan): void
    {
        $operators = User::where('role', 'operator')
            ->when($jenisPengajuan->target_bentuk_pendidikan !== 'semua', fn ($query) => $query->where('bentuk_pendidikan', $jenisPengajuan->target_bentuk_pendidikan))
            ->when($jenisPengajuan->target_status_sekolah !== 'semua', fn ($query) => $query->where('status_sekolah', $jenisPengajuan->target_status_sekolah))
            ->get();
        $operators->each->notify(new TagihanBaru($jenisPengajuan));
    }
}
