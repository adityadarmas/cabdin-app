@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">

    <h4 class="text-xl font-semibold text-slate-800 mb-4">
        Edit Surat Masuk
    </h4>

    @can('update', $suratMasuk)
        <form method="POST"
              action="{{ route('surat-masuk.update', $suratMasuk) }}"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nomor Surat --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nomor Surat
                </label>
                <input type="text"
                       name="nomor_surat"
                       value="{{ old('nomor_surat', $suratMasuk->nomor_surat) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                       required>
                @error('nomor_surat')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Perihal --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Perihal
                </label>
                <input type="text"
                       name="perihal"
                       value="{{ old('perihal', $suratMasuk->perihal) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                       required>
                @error('perihal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Asal --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Asal Surat
                </label>
                <input type="text"
                       name="asal"
                       value="{{ old('asal', $suratMasuk->asal) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                       required>
                @error('asal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Tanggal Diterima
                </label>
                <input type="date"
                       name="tgl_diterima"
                       value="{{ old('tgl_diterima', $suratMasuk->tgl_diterima) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400"
                       required>
                @error('tgl_diterima')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sifat --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Sifat Surat
                </label>
                <select name="sifat"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-sky-400"
                        required>
                    <option value="">-- Pilih Sifat Surat --</option>
                    @foreach (['segera','penting','biasa'] as $sifat)
                        <option value="{{ $sifat }}"
                            {{ old('sifat', $suratMasuk->sifat) == $sifat ? 'selected' : '' }}>
                            {{ ucfirst($sifat) }}
                        </option>
                    @endforeach
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
                <select name="jenis"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-sky-400"
                        required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach (['mutasi','izin_penelitian','pemberitahuan'] as $jenis)
                        <option value="{{ $jenis }}"
                            {{ old('jenis', $suratMasuk->jenis) == $jenis ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_',' ', $jenis)) }}
                        </option>
                    @endforeach
                </select>
                @error('jenis')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- File Surat --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Upload Surat (opsional)
                </label>

                @if ($suratMasuk->filepath)
                    <p class="text-xs text-slate-500 mb-1">
                        File saat ini:
                        <a href="{{ asset('storage/'.$suratMasuk->filepath) }}"
                           target="_blank"
                           class="text-sky-600 hover:underline">
                            Lihat File
                        </a>
                    </p>
                @endif

                <input type="file"
                       name="filepath"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-sky-400">

                @error('filepath')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tamu --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Tamu / Pengirim
                </label>
                <select name="tamu_id"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-sky-400"
                        required>
                    <option value="">-- Pilih Tamu --</option>
                    @foreach ($tamu as $tamu)
                        <option value="{{ $tamu->id }}"
                            {{ old('tamu_id', $suratMasuk->tamu_id) == $tamu->id ? 'selected' : '' }}>
                            {{ $tamu->nama }}
                        </option>
                    @endforeach
                </select>
                @error('tamu_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('surat-masuk.index') }}"
                   class="text-sm text-slate-500 hover:text-slate-700">
                    ← Kembali
                </a>

                <button type="submit"
                        class="bg-emerald-500 hover:bg-emerald-600
                               text-white px-5 py-2 rounded-lg text-sm">
                    Update
                </button>
            </div>

        </form>
    @else
        <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-700 text-sm">
            Anda tidak memiliki izin untuk mengedit surat ini.
        </div>
    @endcan

</div>
@endsection
