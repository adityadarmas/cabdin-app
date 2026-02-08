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

                    {{-- Nomor Surat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Nomor Surat
                        </label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="Contoh: 420/123/2026" required>
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
                            placeholder="Perihal surat" required>
                        @error('perihal')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Asal --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Asal Surat
                        </label>
                        <input type="text" name="asal" value="{{ old('asal') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="Instansi / Pengirim" required>
                        @error('asal')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- tgl_diterima --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Tanggal Diterima
                        </label>
                        <input type="date" name="tgl_diterima" value="{{ old('tgl_diterima') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="tanggal surat diterima" required>
                        @error('tgl_diterima')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- tgl_kegiatan --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Tanggal Kegiatan
                        </label>
                        <input type="date" name="tgl_kegiatan" value="{{ old('tgl_kegiatan') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="tanggal kegiatan surat" required>
                        @error('tgl_kegiatan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sifat --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Sifat Surat
                        </label>

                        <select name="sifat" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                   focus:outline-none focus:ring-2 focus:ring-sky-400">

                            <option value="" disabled {{ old('sifat') ? '' : 'selected' }}>
                                -- Pilih Sifat Surat --
                            </option>

                            <option value="segera" {{ old('sifat') == 'segera' ? 'selected' : '' }}>
                                Segera
                            </option>

                            <option value="penting" {{ old('sifat') == 'penting' ? 'selected' : '' }}>
                                Penting
                            </option>

                            <option value="biasa" {{ old('sifat') == 'biasa' ? 'selected' : '' }}>
                                Biasa
                            </option>
                        </select>

                        @error('sifat')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Jenis Surat
                        </label>

                        <select name="jenis" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                   focus:outline-none focus:ring-2 focus:ring-sky-400">

                            <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>
                                -- Pilih Jenis Surat --
                            </option>

                            <option value="mutasi" {{ old('jenis') == 'mutasi' ? 'selected' : '' }}>
                                mutasi
                            </option>

                            <option value="izin_penelitian" {{ old('jenis') == 'izin_penelitian' ? 'selected' : '' }}>
                                izin_penelitian
                            </option>

                            <option value="pemberitahuan" {{ old('jenis') == 'pemberitahuan' ? 'selected' : '' }}>
                                pemberitahuan
                            </option>
                        </select>

                        @error('jenis')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload File --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Upload Surat
                        </label>

                        <input type="file" name="file_surat"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                  focus:outline-none focus:ring-2 focus:ring-sky-400
                  file:mr-3 file:rounded-lg file:border-0
                  file:bg-sky-100 file:px-3 file:py-1
                  file:text-sm file:font-medium file:text-sky-700
                  hover:file:bg-sky-200"
                            required>

                        <p class="text-xs text-slate-500 mt-1">
                            Format: PDF / DOC / DOCX (Max 2MB)
                        </p>

                        @error('file_surat')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tamu --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Tamu / Pengirim
                        </label>

                        <select name="tamu_id" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
               focus:outline-none focus:ring-2 focus:ring-sky-400">

                            <option value="" disabled {{ old('tamu_id') ? '' : 'selected' }}>
                                -- Pilih Tamu --
                            </option>

                            @foreach ($tamu as $tamu)
                                <option value="{{ $tamu->id }}" {{ old('tamu_id') == $tamu->id ? 'selected' : '' }}>
                                    {{ $tamu->nama }}
                                    {{-- opsional --}}
                                    {{-- - {{ $tamu->instansi ?? '' }} --}}
                                </option>
                            @endforeach
                        </select>

                        @error('tamu_id')
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
                            class="px-5 py-2 rounded-lg bg-sky-500 text-white
                               hover:bg-sky-600 transition">
                            Simpan Surat
                        </button>
                    </div>

                </form>
            </div>
        @endcan

    </div>
@endsection
