<?php

namespace App\Http\Controllers;

use App\Models\JenisPengajuan;
use Illuminate\Http\Request;

class JenisPengajuanController extends Controller
{
    public function index()
    {
        $jenisPengajuans = JenisPengajuan::orderBy('urutan')->get();
        return view('dashboard.jenis_pengajuan.index', compact('jenisPengajuans'));
    }

    public function create()
    {
        return view('dashboard.jenis_pengajuan.form', ['jenisPengajuan' => new JenisPengajuan()]);
    }

    public function store(Request $request)
    {
        JenisPengajuan::create($this->validated($request));
        return redirect()->route('jenis-pengajuan.index')->with('success', 'Jenis pengajuan berhasil ditambahkan.');
    }

    public function edit(JenisPengajuan $jenisPengajuan)
    {
        return view('dashboard.jenis_pengajuan.form', compact('jenisPengajuan'));
    }

    public function update(Request $request, JenisPengajuan $jenisPengajuan)
    {
        $jenisPengajuan->update($this->validated($request));
        return redirect()->route('jenis-pengajuan.index')->with('success', 'Jenis pengajuan berhasil diperbarui.');
    }

    public function destroy(JenisPengajuan $jenisPengajuan)
    {
        $jenisPengajuan->delete();
        return back()->with('success', 'Jenis pengajuan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate(['nama' => 'required|string|max:255', 'deskripsi' => 'nullable|string|max:2000', 'form_fields' => 'nullable|string', 'urutan' => 'required|integer|min:1', 'is_active' => 'required|boolean']);
        $data['form_fields'] = $this->normaliseFields($data['form_fields'] ?? '');
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
}
