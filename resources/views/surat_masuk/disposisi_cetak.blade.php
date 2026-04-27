@extends('layouts.app')

@php
    $rawHarap     = $suratMasuk->dengan_hormat_harap ?? '';
    $harapParts   = explode(' | ', $rawHarap, 2);
    $harapPilihan = $harapParts[0] ? array_map('trim', explode(',', $harapParts[0])) : [];
    $harapKet     = trim($harapParts[1] ?? '');

    $opsiHarap = [
        'Tanggapan dan saran',
        'Proses lebih lanjut',
        'Koordinasi/Konfirmasikan',
    ];

    $sifatAktif = $suratMasuk->sifat_dispo ?? '';

    // Nama penerima (lowercase) untuk pencocokan checkbox tetap
    $namaPenerima = $suratMasuk->penerima->pluck('name')->map(fn($n) => strtolower($n))->toArray();

    $cekPenerima = function(string $keyword) use ($namaPenerima): bool {
        foreach ($namaPenerima as $nama) {
            if (str_contains($nama, strtolower($keyword))) return true;
        }
        return false;
    };
@endphp

@section('content')

{{-- Tombol aksi (tersembunyi saat cetak) --}}
<div class="no-print max-w-3xl mx-auto px-4 py-4 flex items-center gap-3">
    <a href="{{ route('surat-masuk.index') }}"
       class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 transition">
        ← Kembali
    </a>
    <div class="ml-auto">
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 transition">
            🖨️ Cetak Lembar Disposisi
        </button>
    </div>
</div>

{{-- Area cetak --}}
<div id="lembar-disposisi" class="print-area max-w-3xl mx-auto px-4 pb-10">

    {{-- ── HEADER INSTANSI ── --}}
    <div style="display:flex; align-items:center; border-bottom:4px double #222; padding-bottom:10px; margin-bottom:12px;">
        <img src="{{ asset('images/jatim.png') }}" alt="Logo Jawa Timur"
             style="height:80px; width:auto; margin-right:14px; object-fit:contain;">
        <div style="text-align:center; flex:1; line-height:1.4;">
            <div style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.5px;">
                Pemerintah Provinsi Jawa Timur
            </div>
            <div style="font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.5px;">
                Dinas Pendidikan
            </div>
            <div style="font-size:16px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;">
                Cabang Dinas Wilayah Kabupaten Malang
            </div>
            <div style="font-size:10px; margin-top:3px;">
                Jalan Simpang Ijen Nomor 2, Oro-oro Dowo, Klojen, Malang, Jawa Timur 65119
            </div>
            <div style="font-size:10px;">
                Telepon/Faksimile (0341) 5081868, Pos-el : cabdinmalang@gmail.com
            </div>
        </div>
    </div>

    {{-- ── JUDUL ── --}}
    <div style="text-align:center; font-size:14px; font-weight:700; text-transform:uppercase;
                letter-spacing:3px; border:1.5px solid #222; padding:6px 0; margin-bottom:0;">
        Lembar Disposisi
    </div>

    {{-- ── TABEL UTAMA ── --}}
    <table style="width:100%; border-collapse:collapse; font-size:12px;">
        <tbody>

            {{-- Baris 1: Info surat (2 kolom) --}}
            <tr>
                {{-- Kiri: Surat Dari, Nomor Surat, Tgl Surat --}}
                <td style="border:1px solid #555; padding:8px 12px; vertical-align:top; width:50%;">
                    <table style="border-collapse:collapse; font-size:12px; width:100%;">
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:4px;">Surat Dari</td>
                            <td style="vertical-align:top; padding:0 4px;">:</td>
                            <td style="vertical-align:top;">{{ $suratMasuk->tamu->nama ?? ($suratMasuk->asal ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:4px;">Nomor Surat</td>
                            <td style="vertical-align:top; padding:0 4px;">:</td>
                            <td style="vertical-align:top;">{{ $suratMasuk->nomor_surat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:4px;">Tgl. Surat</td>
                            <td style="vertical-align:top; padding:0 4px;">:</td>
                            <td style="vertical-align:top;">
                                {{ $suratMasuk->tgl_surat ? $suratMasuk->tgl_surat->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                    </table>
                </td>

                {{-- Kanan: Diterima Tgl, Nomor Agenda, Sifat --}}
                <td style="border:1px solid #555; padding:8px 12px; vertical-align:top; width:50%;">
                    <table style="border-collapse:collapse; font-size:12px; width:100%;">
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:4px;">Diterima Tgl</td>
                            <td style="vertical-align:top; padding:0 4px;">:</td>
                            <td style="vertical-align:top;">
                                {{ $suratMasuk->tgl_diterima ? $suratMasuk->tgl_diterima->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:4px;">Nomor Agenda</td>
                            <td style="vertical-align:top; padding:0 4px;">:</td>
                            <td style="vertical-align:top;">{{ $suratMasuk->nomor_agenda ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:4px;">Sifat</td>
                            <td style="vertical-align:top; padding:0 4px;">:</td>
                            <td style="vertical-align:top;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- Baris 2: Sifat checkboxes (kanan) --}}
            <tr>
                <td colspan="2" style="border:1px solid #555; padding:6px 12px; text-align:right;">
                    <span style="display:inline-flex; align-items:center; gap:5px; margin-right:18px;">
                        <span style="display:inline-block; width:13px; height:13px; border:1.5px solid #333;
                                     text-align:center; line-height:11px; font-size:10px;">{{ $sifatAktif === 'sangat_segera' ? '✓' : '' }}</span>
                        Sangat segera
                    </span>
                    <span style="display:inline-flex; align-items:center; gap:5px; margin-right:18px;">
                        <span style="display:inline-block; width:13px; height:13px; border:1.5px solid #333;
                                     text-align:center; line-height:11px; font-size:10px;">{{ $sifatAktif === 'segera' ? '✓' : '' }}</span>
                        Segera
                    </span>
                    <span style="display:inline-flex; align-items:center; gap:5px;">
                        <span style="display:inline-block; width:13px; height:13px; border:1.5px solid #333;
                                     text-align:center; line-height:11px; font-size:10px;">{{ $sifatAktif === 'rahasia' ? '✓' : '' }}</span>
                        Rahasia
                    </span>
                </td>
            </tr>

            {{-- Baris 3: Hal / Perihal --}}
            <tr>
                <td colspan="2" style="border:1px solid #555; padding:10px 12px; height:80px; vertical-align:top;">
                    <table style="border-collapse:collapse; font-size:12px; width:100%;">
                        <tr>
                            <td style="vertical-align:top; white-space:nowrap; padding-right:8px; font-weight:500; width:30px;">Hal</td>
                            <td style="vertical-align:top; padding-right:8px; width:6px;">|</td>
                            <td style="vertical-align:top;">{{ $suratMasuk->perihal ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- Baris 4: Diteruskan kepada & Dengan hormat harap --}}
            <tr>
                {{-- Kiri: Diteruskan kepada --}}
                <td style="border:1px solid #555; padding:8px 12px; vertical-align:top;">
                    <div style="font-weight:600; margin-bottom:8px;">Diteruskan kepada Sdr. :</div>

                    @php
                        $opsiPenerima = [
                            'kasubbag' => 'KASUBBAG TU',
                            'kasi sma' => 'KASI SMA/PK-PLK',
                            'kasi smk' => 'KASI SMK',
                        ];
                    @endphp

                    @foreach ($opsiPenerima as $keyword => $label)
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:5px;">
                            <span style="display:inline-block; width:13px; height:13px; border:1.5px solid #333;
                                         flex-shrink:0; text-align:center; line-height:11px; font-size:10px;">
                                {{ $cekPenerima($keyword) ? '✓' : '' }}
                            </span>
                            <span>{{ $label }}</span>
                        </div>
                    @endforeach

                    <div style="margin-top:8px; font-size:12px;">Dan seterusnya .................................</div>
                </td>

                {{-- Kanan: Dengan hormat harap --}}
                <td style="border:1px solid #555; padding:8px 12px; vertical-align:top;">
                    <div style="font-weight:600; margin-bottom:8px;">Dengan hormat harap :</div>
                    @foreach ($opsiHarap as $opsi)
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:5px;">
                            <span style="display:inline-block; width:13px; height:13px; border:1.5px solid #333;
                                         flex-shrink:0; text-align:center; line-height:11px; font-size:10px;">
                                {{ in_array($opsi, $harapPilihan) ? '✓' : '' }}
                            </span>
                            <span>{{ $opsi }}</span>
                        </div>
                    @endforeach
                    @if ($harapKet)
                        <div style="margin-top:6px; font-size:11px; color:#444;">{{ $harapKet }}</div>
                    @else
                        <div style="margin-top:8px; border-bottom:1px dotted #555; min-width:180px;">&nbsp;</div>
                    @endif
                </td>
            </tr>

            {{-- Baris 5: Catatan --}}
            <tr>
                <td colspan="2" style="border:1px solid #555; padding:8px 12px;">
                    <span style="font-weight:600;">Catatan :</span>
                    @if($suratMasuk->disposisi)
                        <span style="margin-left:6px;">{{ $suratMasuk->disposisi }}</span>
                    @else
                        <span style="display:inline-block; border-bottom:1px dotted #555; width:80%; margin-left:6px;">&nbsp;</span>
                    @endif
                    <div style="border-bottom:1px dotted #555; margin-top:10px; min-height:16px;">&nbsp;</div>
                </td>
            </tr>

        </tbody>
    </table>

    {{-- ── TANDA TANGAN ── --}}
    <div style="display:flex; justify-content:flex-end; margin-top:18px; font-size:12px; text-align:center;">
        <div style="min-width:230px;">
            <div style="font-weight:700; text-transform:uppercase; line-height:1.5;">
                Kepala Cabang Dinas Pendidikan<br>Wilayah Kabupaten Malang
            </div>
            <div style="height:70px;"></div>
            <div style="font-weight:700; border-top:1.5px solid #222; padding-top:4px;">
                DWI ANGGRAENI, S.Pd., M.Pd.
            </div>
        </div>
    </div>

</div>{{-- end #lembar-disposisi --}}

<style>
    @media print {
        .no-print         { display: none !important; }
        nav, header,
        footer, aside     { display: none !important; }
        body              { background: white !important; }
        #lembar-disposisi { max-width: 100% !important; padding: 0 !important; }
        .print-area       { padding: 0 !important; }
        table             { page-break-inside: avoid; }
    }
</style>

@endsection
