@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 print:hidden">
    <a href="{{ route('surat-masuk.index') }}"
       class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 transition mb-4">
        ← Kembali
    </a>
    <h4 class="text-xl font-bold text-slate-800 mb-1">🏷️ Cetak Kitir Surat</h4>
    <p class="text-sm text-slate-500 mb-6">{{ $suratMasuk->nomor_surat }}</p>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- FORM EDIT ISI KITIR --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">
        <h5 class="text-base font-semibold text-slate-700 mb-4">Edit Isi Kitir</h5>
        <form method="POST" action="{{ route('surat-masuk.kitir.update', $suratMasuk) }}">
            @csrf

            {{-- PILIH TEMPLATE OTOMATIS --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Template Berdasarkan Jenis Surat
                </label>
                <div class="flex gap-2">
                    <select id="template-selector"
                        class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                        <option value="_default" {{ !$suratMasuk->jenis ? 'selected' : '' }}>— Umum / Lainnya</option>
                        <option value="mutasi" {{ $suratMasuk->jenis === 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                        <option value="izin_penelitian" {{ $suratMasuk->jenis === 'izin_penelitian' ? 'selected' : '' }}>Izin Penelitian</option>
                        <option value="pemberitahuan" {{ $suratMasuk->jenis === 'pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
                    </select>
                    <button type="button" id="btn-terapkan"
                        class="px-4 py-2 rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 transition text-sm font-medium shrink-0">
                        Terapkan
                    </button>
                </div>
                <p class="mt-1 text-xs text-slate-400">Pilih jenis lalu klik Terapkan untuk mengisi otomatis.</p>
            </div>

            {{-- TEXTAREA ISI KITIR --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Isi Kitir <span class="text-red-500">*</span>
                </label>
                <textarea name="kitir_isi" id="kitir-isi" rows="6" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono
                           focus:outline-none focus:ring-2 focus:ring-sky-400"
                    placeholder="Isi kitir surat...">{{ old('kitir_isi', $suratMasuk->kitir_isi) }}</textarea>
                @error('kitir_isi')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition text-sm font-medium">
                    💾 Simpan
                </button>
                <button type="button" onclick="window.print()"
                    class="px-5 py-2 rounded-lg bg-slate-700 text-white hover:bg-slate-800 transition text-sm font-medium">
                    🖨️ Cetak Kitir
                </button>
            </div>
        </form>
    </div>

    {{-- PREVIEW KITIR --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <h5 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">Preview Kitir</h5>
        <div class="border-2 border-dashed border-slate-400 rounded-lg p-4 max-w-xs">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 text-center mb-2">
                Kitir Surat Masuk
            </p>
            <div class="border-t border-slate-300 pt-2 space-y-1.5 text-xs">
                <div class="flex gap-1">
                    <span class="font-semibold text-slate-600 w-20 shrink-0">No. Surat</span>
                    <span class="text-slate-400">:</span>
                    <span class="text-slate-800 font-medium">{{ $suratMasuk->nomor_surat }}</span>
                </div>
                <div class="flex gap-1">
                    <span class="font-semibold text-slate-600 w-20 shrink-0">Tgl. Terima</span>
                    <span class="text-slate-400">:</span>
                    <span class="text-slate-800">{{ $suratMasuk->tgl_diterima ? $suratMasuk->tgl_diterima->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="flex gap-1 pt-1 border-t border-slate-200">
                    <span class="font-semibold text-slate-600 w-20 shrink-0">Isi</span>
                    <span class="text-slate-400">:</span>
                    <span class="text-slate-800 leading-snug whitespace-pre-line" id="preview-isi">{{ $suratMasuk->kitir_isi }}</span>
                </div>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-3">* Preview tampilan aktual kitir saat dicetak.</p>
    </div>
</div>

{{-- AREA CETAK — hanya muncul saat print --}}
<div class="hidden print:block">
    <style>
        @media print {
            @page { size: 9cm 6cm; margin: 4mm; }
            body * { visibility: hidden; }
            #kitir-print, #kitir-print * { visibility: visible; }
            #kitir-print { position: fixed; left: 0; top: 0; width: 100%; }
        }
    </style>
    <div id="kitir-print" style="font-family: Arial, sans-serif; border: 1.5px dashed #666; padding: 6px 8px; width: 100%; box-sizing: border-box;">
        <p style="font-size: 8pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; text-align: center; margin: 0 0 4px 0; color: #444;">
            Kitir Surat Masuk
        </p>
        <hr style="border: none; border-top: 1px solid #999; margin-bottom: 4px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt; color: #222;">
            <tr>
                <td style="font-weight: 600; width: 72px; vertical-align: top; padding: 1px 0;">No. Surat</td>
                <td style="vertical-align: top; padding: 1px 2px;">:</td>
                <td style="font-weight: 700; vertical-align: top; padding: 1px 0;">{{ $suratMasuk->nomor_surat }}</td>
            </tr>
            <tr>
                <td style="font-weight: 600; vertical-align: top; padding: 1px 0;">Tgl. Terima</td>
                <td style="vertical-align: top; padding: 1px 2px;">:</td>
                <td style="vertical-align: top; padding: 1px 0;">{{ $suratMasuk->tgl_diterima ? $suratMasuk->tgl_diterima->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr style="border-top: 1px solid #ccc;">
                <td style="font-weight: 600; vertical-align: top; padding: 3px 0 1px;">Isi</td>
                <td style="vertical-align: top; padding: 3px 2px 1px;">:</td>
                <td style="vertical-align: top; padding: 3px 0 1px; line-height: 1.4; white-space: pre-wrap;" id="print-isi">{{ $suratMasuk->kitir_isi }}</td>
            </tr>
        </table>
    </div>
</div>

@push('scripts')
<script>
    const templates = @json($kitirTemplates);

    const selector   = document.getElementById('template-selector');
    const textarea   = document.getElementById('kitir-isi');
    const previewIsi = document.getElementById('preview-isi');
    const printIsi   = document.getElementById('print-isi');
    const btnTerapkan = document.getElementById('btn-terapkan');

    function applyTemplate(key) {
        const tpl = templates[key] ?? templates['_default'];
        textarea.value = tpl;
        syncPreview(tpl);
    }

    function syncPreview(text) {
        const val = text || '(kosong)';
        if (previewIsi) previewIsi.textContent = val;
        if (printIsi)   printIsi.textContent   = val;
    }

    // Terapkan template saat tombol diklik
    btnTerapkan.addEventListener('click', function () {
        if (confirm('Terapkan template? Isi kitir saat ini akan diganti.')) {
            applyTemplate(selector.value);
        }
    });

    // Live preview saat mengetik
    textarea.addEventListener('input', function () {
        syncPreview(this.value);
    });
</script>
@endpush
@endsection
