{{--
    ============================================================
    TEMPLATE LEMBAR DISPOSISI — DAPAT DISESUAIKAN
    ============================================================
    File ini adalah template cetak lembar disposisi.
    Anda bisa mengubah:
      - Nama instansi / header di bagian "HEADER INSTANSI"
      - Tata letak tabel di bagian "TABEL INFO SURAT"
      - Pilihan "Dengan Hormat Harap" di bagian "DENGAN HORMAT HARAP"
      - Area tanda tangan di bagian "TANDA TANGAN"
    ============================================================
--}}
@extends('layouts.app')

@php
    // ── Parse "dengan_hormat_harap" ──────────────────────────
    // Format simpan: "Pilihan 1, Pilihan 2 | Keterangan tambahan"
    $rawHarap     = $suratMasuk->dengan_hormat_harap ?? '';
    $harapParts   = explode(' | ', $rawHarap, 2);
    $harapPilihan = $harapParts[0] ? array_map('trim', explode(',', $harapParts[0])) : [];
    $harapKet     = trim($harapParts[1] ?? '');

    // ── Daftar opsi "Dengan Hormat Harap" ───────────────────
    // Tambah atau ubah opsi di sini sesuai kebutuhan instansi
    $opsiHarap = [
        'Tanggapan dan saran',
        'Proses lebih lanjut',
        'Koordinasikan / konfirmasikan',
    ];

    // ── Label sifat disposisi ────────────────────────────────
    $sifatLabel = [
        'sangat_segera' => 'Sangat Segera',
        'segera'        => 'Segera',
        'rahasia'       => 'Rahasia',
    ];
    $sifatTeks = $sifatLabel[$suratMasuk->sifat_dispo ?? ''] ?? ucfirst(str_replace('_', ' ', $suratMasuk->sifat_dispo ?? '-'));
@endphp

@section('content')

    {{-- ===================================================
         TOMBOL AKSI (tersembunyi saat cetak)
         =================================================== --}}
    <div class="no-print max-w-3xl mx-auto px-4 py-4 flex items-center gap-3">
        <a href="{{ route('surat-masuk.index') }}"
           class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 transition">
            ← Kembali
        </a>
        <div class="ml-auto flex gap-2">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 transition">
                🖨️ Cetak Lembar Disposisi
            </button>
        </div>
    </div>

    {{-- ===================================================
         AREA CETAK — modifikasi konten di dalam div ini
         =================================================== --}}
    <div id="lembar-disposisi" class="print-area max-w-3xl mx-auto px-4 pb-10">

        {{-- ── HEADER INSTANSI ────────────────────────────
             Sesuaikan nama instansi, alamat, dan nomor telepon
             ─────────────────────────────────────────────── --}}
        <div class="header-instansi border-b-4 border-double border-slate-800 pb-3 mb-4 flex items-center gap-4">
            {{-- Logo (opsional — hapus tag img ini jika tidak diperlukan) --}}
            {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 object-contain"> --}}
            <div class="text-center flex-1">
                <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Pemerintah Provinsi Jawa Timur</p>
                <p class="text-base font-bold uppercase tracking-wide text-slate-900">Dinas Pendidikan</p>
                <p class="text-sm font-bold uppercase tracking-wide text-slate-900">Cabang Dinas Pendidikan Wilayah Kabupaten Malang</p>
                <p class="text-xs text-slate-600 mt-0.5">
                    Jl. Raya ... No. ... Malang — Telp. (0341) ... — Fax. (0341) ...
                </p>
            </div>
        </div>

        {{-- ── JUDUL ─────────────────────────────────────── --}}
        <h2 class="text-center text-base font-bold uppercase tracking-widest text-slate-900 mb-4 border border-slate-700 py-1.5">
            Lembar Disposisi
        </h2>

        {{-- ── TABEL INFO SURAT ─────────────────────────── --}}
        <table class="w-full text-sm border border-slate-400 border-collapse mb-4">
            <tbody>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700 w-2/5">Nomor Agenda</td>
                    <td class="border border-slate-400 px-3 py-1.5">: {{ $suratMasuk->nomor_agenda ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700">Tanggal Diterima</td>
                    <td class="border border-slate-400 px-3 py-1.5">
                        : {{ $suratMasuk->tgl_diterima ? $suratMasuk->tgl_diterima->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700">Nomor Surat</td>
                    <td class="border border-slate-400 px-3 py-1.5">: {{ $suratMasuk->nomor_surat }}</td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700">Tanggal Surat</td>
                    <td class="border border-slate-400 px-3 py-1.5">
                        : {{ $suratMasuk->tgl_surat ? $suratMasuk->tgl_surat->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700">Asal Surat</td>
                    <td class="border border-slate-400 px-3 py-1.5">: {{ $suratMasuk->tamu->nama ?? ($suratMasuk->asal ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700">Perihal</td>
                    <td class="border border-slate-400 px-3 py-1.5">: {{ $suratMasuk->perihal }}</td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700">Sifat</td>
                    <td class="border border-slate-400 px-3 py-1.5">: {{ $sifatTeks }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ── DITERUSKAN KEPADA ────────────────────────── --}}
        <table class="w-full text-sm border border-slate-400 border-collapse mb-4">
            <tbody>
                <tr>
                    <td colspan="2" class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700 bg-slate-50">
                        Diteruskan Kepada
                    </td>
                </tr>
                @forelse ($suratMasuk->penerima as $penerima)
                    <tr>
                        <td class="border border-slate-400 px-3 py-1.5 w-8 text-center">
                            <span class="inline-block w-4 h-4 border border-slate-600 align-middle"></span>
                        </td>
                        <td class="border border-slate-400 px-3 py-1.5">{{ $penerima->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border border-slate-400 px-3 py-1.5 italic text-slate-400">
                            Belum ada penerima disposisi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ── DENGAN HORMAT HARAP ──────────────────────── --}}
        <table class="w-full text-sm border border-slate-400 border-collapse mb-4">
            <tbody>
                <tr>
                    <td colspan="2" class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700 bg-slate-50">
                        Dengan Hormat Harap
                    </td>
                </tr>
                @foreach ($opsiHarap as $opsi)
                    <tr>
                        <td class="border border-slate-400 px-3 py-1.5 w-8 text-center">
                            @if(in_array($opsi, $harapPilihan))
                                <span class="font-bold text-base">✓</span>
                            @else
                                <span class="inline-block w-4 h-4 border border-slate-600 align-middle"></span>
                            @endif
                        </td>
                        <td class="border border-slate-400 px-3 py-1.5">{{ $opsi }}</td>
                    </tr>
                @endforeach
                @if ($harapKet)
                    <tr>
                        <td colspan="2" class="border border-slate-400 px-3 py-1.5">
                            <span class="font-semibold text-slate-700">Keterangan:</span>
                            {{ $harapKet }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- ── CATATAN DISPOSISI ────────────────────────── --}}
        <table class="w-full text-sm border border-slate-400 border-collapse mb-4">
            <tbody>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700 bg-slate-50">
                        Catatan Disposisi
                    </td>
                </tr>
                <tr>
                    <td class="border border-slate-400 px-3 py-3 min-h-[60px]" style="height: 70px; vertical-align: top;">
                        {{ $suratMasuk->disposisi ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ── TANGGAL KEGIATAN ─────────────────────────── --}}
        <table class="w-full text-sm border border-slate-400 border-collapse mb-6">
            <tbody>
                <tr>
                    <td class="border border-slate-400 px-3 py-1.5 font-semibold text-slate-700 w-2/5">Tanggal Kegiatan</td>
                    <td class="border border-slate-400 px-3 py-1.5">
                        : {{ $suratMasuk->tgl_kegiatan ? $suratMasuk->tgl_kegiatan->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ── TANDA TANGAN ─────────────────────────────── --}}
        {{-- Sesuaikan nama kota, jabatan, dan nama pejabat di sini --}}
        <div class="flex justify-end text-sm text-slate-800">
            <div class="text-center" style="min-width: 220px;">
                <p>Malang, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="mt-1">Kepala Cabang Dinas Pendidikan</p>
                <p>Wilayah Kab. Malang,</p>

                {{-- Ruang tanda tangan --}}
                <div style="height: 70px;"></div>

                <p class="font-semibold border-t border-slate-700 pt-1 mt-1">(______________________________)</p>
                <p class="text-xs text-slate-600">NIP. ________________________</p>
            </div>
        </div>

    </div>{{-- end .print-area --}}

    {{-- ===================================================
         STYLE CETAK
         =================================================== --}}
    <style>
        @media print {
            .no-print          { display: none !important; }
            nav, header,
            footer, aside      { display: none !important; }
            body               { background: white !important; }
            #lembar-disposisi  { max-width: 100% !important; padding: 0 !important; }
            .print-area        { padding: 0 !important; }
            table              { page-break-inside: avoid; }
        }
    </style>

@endsection
