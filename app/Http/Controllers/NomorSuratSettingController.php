<?php

namespace App\Http\Controllers;

use App\Models\NomorSuratSetting;
use Illuminate\Http\Request;

class NomorSuratSettingController extends Controller
{
    public function edit()
    {
        $setting = NomorSuratSetting::firstOrFail();
        return view('admin.nomor_surat_setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'counter' => 'required|integer|min:0',
            'padding' => 'required|integer|min:1|max:6',
        ]);

        NomorSuratSetting::firstOrFail()->update($validated);

        return redirect()->route('admin.nomor-surat-setting.edit')
            ->with('success', 'Pengaturan nomor surat berhasil disimpan.');
    }
}
