@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6">
        <a href="{{ route('surat-masuk.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition">
            ← Kembali
        </a>

        <!-- JUDUL -->
        <h4 class="text-2xl font-bold text-slate-800 mb-6">
            Detail Surat Masuk
        </h4>

        <!-- DETAIL SURAT -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-slate-200">

                    <tr>
                        <th class="w-1/3 px-4 py-3 text-left font-medium text-slate-600">
                            Nomor Surat
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->nomor_surat }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Perihal
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->perihal }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Asal
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->asal }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Tanggal Diterima
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->tgl_diterima }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Sifat
                        </th>
                        <td class="px-4 py-3 text-slate-800 capitalize">
                            {{ $suratMasuk->sifat_dispo }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Jenis
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->jenis }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Dari (Tamu)
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->tamu->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Harap dilaksanakan
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->dengan_hormat_harap }}
                        </td>
                    </tr>

                    {{-- <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Status Surat
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->status }}
                        </td>
                    </tr> --}}

                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            Keterangan
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            {{ $suratMasuk->disposisi ?? '-' }}
                        </td>
                    </tr>

                    {{-- FILE SURAT --}}
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">
                            File Surat
                        </th>
                        <td class="px-4 py-3 text-slate-800">
                            @if ($suratMasuk->filepath)
                                <div class="flex gap-3">

                                    <a href="{{ asset('storage/' . $suratMasuk->filepath) }}" target="_blank"
                                        class="px-3 py-1.5 rounded-lg text-sm
                                          bg-sky-100 text-sky-700
                                          hover:bg-sky-200 transition">
                                        📄 Buka PDF
                                    </a>

                                    <a href="{{ asset('storage/' . $suratMasuk->filepath) }}" download
                                        class="px-3 py-1.5 rounded-lg text-sm
                                          bg-slate-100 text-slate-700
                                          hover:bg-slate-200 transition">
                                        ⬇ Download
                                    </a>

                                </div>
                            @else
                                <span class="italic text-slate-400">
                                    Tidak ada file
                                </span>
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- PREVIEW PDF --}}
        @if ($suratMasuk->filepath && Str::endsWith($suratMasuk->filepath, '.pdf'))
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-slate-200 p-4">

                <h5 class="text-base font-semibold text-slate-700 mb-3">
                    Preview Surat (PDF)
                </h5>

                <iframe src="{{ asset('storage/' . $suratMasuk->filepath) }}" class="w-full h-[650px] border rounded-lg"
                    loading="lazy">
                </iframe>

            </div>
        @endif


        {{-- HANYA PIMPINAN --}}
        @can('disposisi', $suratMasuk)
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-slate-200 p-6">

                <h5 class="text-lg font-semibold text-slate-800 mb-4">
                    Disposisi
                </h5>

                <form method="POST" action="{{ route('surat-masuk.disposisi', $suratMasuk) }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <h2>Tujuan (Staff)</h2>
                        <select name="user_id" required>
                            <option value="">-- Pilih Staff --</option>
                            @foreach ($staff as $user)
                                <option value="{{ $user->id }}" {{ $suratMasuk->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- sifat disposisis --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Sifat Disposisi
                        </label>

                        <div class="space-y-2">
                            @php
                                $sifatList = [
                                    'sangat_segera' => 'Sangat Segera',
                                    'segera' => 'Segera',
                                    'rahasia' => 'Rahasia',
                                ];
                            @endphp

                            @foreach ($sifatList as $value => $label)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="sifat_dispo" value="{{ $value }}"
                                        class="sifat-dispo rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                        {{ old('sifat_dispo', $suratMasuk->sifat_dispo ?? '') === $value ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Dengan Hormat Harap --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Dengan Hormat Harap
                        </label>

                        @php
                            $pilihanList = [
                                'Tanggapan dan saran',
                                'Proses lebih lanjut',
                                'Koordinasikan / konfirmasikan',
                            ];
                        @endphp

                        <div class="space-y-2 mb-3">
                            @foreach ($pilihanList as $item)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="harap_pilihan[]" value="{{ $item }}"
                                        class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                    <span class="text-sm text-slate-700">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>

                        {{-- Keterangan --}}
                        <textarea name="harap_keterangan" rows="3"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
               focus:outline-none focus:ring-2 focus:ring-sky-500"
                            placeholder="Keterangan tambahan (opsional)..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Catatan Disposisi
                        </label>
                        <textarea name="disposisi" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                                     focus:outline-none focus:ring-2 focus:ring-sky-500">{{ $suratMasuk->disposisi }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white
                                   px-5 py-2 rounded-lg transition">
                            Simpan Disposisi
                        </button>
                    </div>

                </form>
            </div>
        @endcan

    </div>
@endsection
