@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6">
        <a href="{{ route('surat-masuk.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition">
            ← Kembali
        </a>

        <h1 class="text-2xl font-semibold text-slate-800 mb-6">
            Tambah Surat Masuk
        </h1>

        @can('create', App\Models\SuratMasuk::class)
            <div class="bg-white rounded-xl shadow p-6">

                <form method="POST" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Pilihan Utama: Disposisi atau Bukan --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Jenis Surat Masuk
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_disposisi" value="0" id="radio_bukan"
                                    {{ old('is_disposisi', '0') == '0' ? 'checked' : '' }}
                                    class="accent-sky-500">
                                <span class="text-sm text-slate-700">Bukan Disposisi</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_disposisi" value="1" id="radio_disposisi"
                                    {{ old('is_disposisi') == '1' ? 'checked' : '' }}
                                    class="accent-sky-500">
                                <span class="text-sm text-slate-700">Disposisi</span>
                            </label>
                        </div>
                    </div>

                    {{-- ======== FORM: BUKAN DISPOSISI ======== --}}
                    <div id="form_bukan_disposisi" class="space-y-5">

                        {{-- Nama Pengirim --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Nama Pengirim
                            </label>
                            <select name="tamu_id" id="tamu_select_bukan"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400">
                                <option value="" disabled {{ old('tamu_id') ? '' : 'selected' }}>
                                    -- Pilih Pengirim --
                                </option>
                                @foreach ($tamu as $t)
                                    <option value="{{ $t->id }}"
                                        {{ old('tamu_id') == $t->id ? 'selected' : '' }}>
                                        {{ $t->nama }} — {{ $t->asal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tamu_id')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Perihal --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Perihal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="perihal" value="{{ old('perihal') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Perihal surat">
                            @error('perihal')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Diterima --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Diterima
                            </label>
                            <input type="date" name="tgl_diterima" value="{{ old('tgl_diterima') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400">
                            @error('tgl_diterima')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Surat --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Jenis Surat
                            </label>
                            <select name="jenis"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400">
                                <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>
                                    -- Pilih Jenis Surat --
                                </option>
                                <option value="mutasi" {{ old('jenis') == 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                                <option value="izin_penelitian" {{ old('jenis') == 'izin_penelitian' ? 'selected' : '' }}>Izin Penelitian</option>
                                <option value="pemberitahuan" {{ old('jenis') == 'pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
                            </select>
                            @error('jenis')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        {{-- <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Keterangan
                            </label>
                            <textarea name="keterangan" rows="3"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                    </div>

                    {{-- ======== FORM: DISPOSISI ======== --}}
                    <div id="form_disposisi" class="space-y-5 hidden">

                        {{-- Tamu / Pengirim --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tamu / Pengirim
                            </label>
                            <select name="tamu_id_disposisi" id="tamu_select_disposisi"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400">
                                <option value="" disabled selected>-- Pilih Tamu --</option>
                                @foreach ($tamu as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->nama }} — {{ $t->asal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nomor Surat --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Nomor Surat
                            </label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Contoh: 420/123/2026">
                            @error('nomor_surat')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Perihal --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Perihal
                            </label>
                            <input type="text" name="perihal" value="{{ old('perihal') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Perihal surat">
                            @error('perihal')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Surat --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Surat
                            </label>
                            <input type="date" name="tgl_surat" value="{{ old('tgl_surat') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400">
                            @error('tgl_surat')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Diterima --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Diterima
                            </label>
                            <input type="date" name="tgl_diterima_disposisi" value="{{ old('tgl_diterima_disposisi') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400">
                        </div>

                        {{-- Nomor Agenda --}}
                        {{-- <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Nomor Agenda
                            </label>
                            <input type="text" name="nomor_agenda" value="{{ old('nomor_agenda') }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2
                                       focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Nomor agenda surat">
                            @error('nomor_agenda')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                    </div>

                    {{-- ======== SHARED FIELDS ======== --}}

                    {{-- Ringkasan Isi Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Ringkasan Isi Surat
                        </label>
                        <textarea name="ringkasan" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="Tuliskan ringkasan isi surat...">{{ old('ringkasan') }}</textarea>
                        @error('ringkasan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload File Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Upload File Surat
                            <span class="text-xs font-normal text-slate-400">(PDF / DOC / DOCX, maks 10 MB)</span>
                        </label>
                        <input type="file" name="filepath" accept=".pdf,.doc,.docx"
                            class="w-full text-sm text-slate-600
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-medium
                                   file:bg-sky-50 file:text-sky-700
                                   hover:file:bg-sky-100 cursor-pointer">
                        @error('filepath')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Aksi --}}
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('surat-masuk.index') }}"
                            class="px-4 py-2 rounded-lg border text-slate-600 hover:bg-slate-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-lg bg-sky-500 text-white hover:bg-sky-600 transition">
                            Simpan Surat
                        </button>
                    </div>

                </form>
            </div>
        @endcan

    </div>

@push('scripts')
<script>
    const radioDisposisi = document.getElementById('radio_disposisi');
    const radioBukan     = document.getElementById('radio_bukan');
    const formBukan      = document.getElementById('form_bukan_disposisi');
    const formDisposisi  = document.getElementById('form_disposisi');

    function toggleForm() {
        if (radioDisposisi.checked) {
            formBukan.classList.add('hidden');
            formDisposisi.classList.remove('hidden');

            // Sync tamu_id: copy disposisi select value to bukan select (and vice versa)
            setRequired(formDisposisi, true);
            setRequired(formBukan, false);
        } else {
            formBukan.classList.remove('hidden');
            formDisposisi.classList.add('hidden');

            setRequired(formBukan, true);
            setRequired(formDisposisi, false);
        }
    }

    function setRequired(section, required) {
        // We handle required via server validation; just ensure disabled state
        section.querySelectorAll('input, select, textarea').forEach(el => {
            el.disabled = !required;
        });
    }

    // Sync tamu_id across both forms before submit
    document.querySelector('form').addEventListener('submit', function () {
        if (radioDisposisi.checked) {
            const val = document.getElementById('tamu_select_disposisi').value;
            document.getElementById('tamu_select_bukan').value = val;
            // Also sync tgl_diterima
            const tglDispo = document.querySelector('[name="tgl_diterima_disposisi"]').value;
            document.querySelector('[name="tgl_diterima"]').value = tglDispo;
        }
        // Re-enable all fields so they submit
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.disabled = false;
        });
    });

    radioDisposisi.addEventListener('change', toggleForm);
    radioBukan.addEventListener('change', toggleForm);

    // Init on page load
    toggleForm();
</script>
@endpush

@endsection
