<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Surat Masuk — {{ $suratMasuk->nomor_surat }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            background: #f1f5f9;
            color: #1e293b;
        }

        /* ── toolbar (layar saja) ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #1e293b;
            color: #fff;
            padding: 10px 20px;
        }
        .toolbar h1 { font-size: 14pt; font-weight: 700; flex: 1; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 10pt;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-print { background: #0ea5e9; color: #fff; }
        .btn-back  { background: #475569; color: #fff; }
        .btn:hover { opacity: .88; }

        /* ── wrapper ── */
        .page-wrapper {
            max-width: 780px;
            margin: 24px auto;
            padding: 0 16px 40px;
        }

        /* ── kartu tanda terima ── */
        .receipt {
            background: #fff;
            border: 1.5px solid #94a3b8;
            padding: 18px 22px 14px;
            margin-bottom: 0;
        }

        /* ── header instansi ── */
        .receipt-header {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 4px double #1e293b;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .receipt-header img.logo {
            height: 70px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }
        .receipt-header .instansi-wrap {
            flex: 1;
            text-align: center;
            line-height: 1.45;
        }
        .instansi-wrap .baris-kecil {
            font-size: 9pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .instansi-wrap .baris-dinas {
            font-size: 11pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .instansi-wrap .baris-besar {
            font-size: 14pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .instansi-wrap .baris-alamat {
            font-size: 7.5pt;
            color: #475569;
            margin-top: 3px;
        }

        /* ── judul ── */
        .receipt-title {
            text-align: center;
            font-size: 11pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1.5px solid #1e293b;
            padding: 5px 0;
            margin-bottom: 12px;
            color: #0f172a;
        }

        /* ── body: detail + qr ── */
        .receipt-body {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }
        .receipt-details { flex: 1; }

        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }
        table.detail-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.detail-table td:first-child {
            width: 120px;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
        }
        table.detail-table td:nth-child(2) {
            width: 12px;
            color: #64748b;
        }

        /* ── QR ── */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }
        .qr-box {
            width: 82px;
            height: 82px;
            border: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            overflow: hidden;
        }
        .qr-label {
            font-size: 7pt;
            color: #64748b;
            text-align: center;
            line-height: 1.3;
        }

        /* ── status badge ── */
        .status-badge {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 99px;
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .status-diterima     { background: #dbeafe; color: #1d4ed8; }
        .status-dikirim      { background: #fef9c3; color: #a16207; }
        .status-disetujui    { background: #ede9fe; color: #6d28d9; }
        .status-siap_diambil { background: #dcfce7; color: #166534; }
        .status-disposisi    { background: #ccfbf1; color: #0f766e; }

        /* ── tanda tangan ── */
        .signature-area {
            display: flex;
            gap: 12px;
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid #cbd5e1;
        }
        .sig-box {
            flex: 1;
            text-align: center;
            font-size: 9pt;
        }
        .sig-box .sig-place {
            margin-bottom: 2px;
            color: #334155;
        }
        .sig-box .sig-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 44px;
        }
        .sig-box .sig-name {
            font-weight: 700;
            border-top: 1.5px solid #1e293b;
            padding-top: 3px;
            color: #0f172a;
        }
        .sig-box .sig-nip {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 1px;
        }

        /* ── link tracking ── */
        .tracking-note {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px solid #e2e8f0;
            word-break: break-all;
        }

        /* ── garis potong ── */
        .cut-line {
            text-align: center;
            color: #94a3b8;
            font-size: 8.5pt;
            letter-spacing: 3px;
            padding: 10px 0;
            position: relative;
        }
        .cut-line::before,
        .cut-line::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 90px);
            border-top: 1.5px dashed #cbd5e1;
        }
        .cut-line::before { left: 0; }
        .cut-line::after  { right: 0; }

        /* ── PRINT ── */
        @media print {
            @page {
                size: A5;
                margin: 8mm 10mm;
            }
            body        { background: #fff; }
            .toolbar    { display: none !important; }
            .page-wrapper {
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
            .receipt {
                border: 1.5px solid #475569;
                padding: 10px 12px 8px;
                break-inside: avoid;
            }
            .cut-line {
                break-before: always;
                padding: 4px 0;
            }
        }
    </style>
</head>
<body>

{{-- ── TOOLBAR ── --}}
<div class="toolbar">
    <h1>Tanda Terima Surat Masuk</h1>
    <a href="{{ route('surat-masuk.index') }}" class="btn btn-back">← Kembali</a>
    <button onclick="window.print()" class="btn btn-print">🖨️ Cetak</button>
</div>

<div class="page-wrapper">

    @php
        $asal        = $suratMasuk->asal ?: ($suratMasuk->tamu->nama ?? '-');
        $tglTerima   = $suratMasuk->tgl_diterima
                         ? $suratMasuk->tgl_diterima->translatedFormat('d F Y') : '-';
        $trackingUrl = $suratMasuk->tracking_url;
        $statusLabels = [
            'diterima'     => ['label' => 'Diterima',     'cls' => 'status-diterima'],
            'dikirim'      => ['label' => 'Dikirim',      'cls' => 'status-dikirim'],
            'disetujui'    => ['label' => 'Disetujui',    'cls' => 'status-disetujui'],
            'siap_diambil' => ['label' => 'Siap Diambil', 'cls' => 'status-siap_diambil'],
            'disposisi'    => ['label' => 'Disposisi',    'cls' => 'status-disposisi'],
        ];
        $st = $statusLabels[$suratMasuk->status]
           ?? ['label' => ucfirst($suratMasuk->status), 'cls' => ''];
        $tglMalang = 'Malang, ' . now()->translatedFormat('d F Y');
    @endphp

    {{-- ── LEMBAR 1 (untuk pengirim / tamu) ── --}}
    <div class="receipt" id="receipt-1">

        {{-- Header instansi --}}
        <div class="receipt-header">
            <img src="{{ asset('images/jatim.png') }}" alt="Logo Jawa Timur" class="logo">
            <div class="instansi-wrap">
                <div class="baris-kecil">Pemerintah Provinsi Jawa Timur</div>
                <div class="baris-dinas">Dinas Pendidikan</div>
                <div class="baris-besar">Cabang Dinas Wilayah Kabupaten Malang</div>
                <div class="baris-alamat">
                    Jalan Simpang Ijen Nomor 2, Oro-oro Dowo, Klojen, Malang, Jawa Timur 65119<br>
                    Telepon/Faksimile (0341) 5081868 &nbsp;|&nbsp; cabdinmalang@gmail.com
                </div>
            </div>
        </div>

        <div class="receipt-title">Tanda Terima Surat Masuk</div>

        <div class="receipt-body">
            <div class="receipt-details">
                <table class="detail-table">
                    <tr>
                        <td>Nomor Agenda</td>
                        <td>:</td>
                        <td>{{ $suratMasuk->nomor_agenda ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Surat</td>
                        <td>:</td>
                        <td><strong>{{ $suratMasuk->nomor_surat }}</strong></td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $suratMasuk->perihal ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Dari / Pengirim</td>
                        <td>:</td>
                        <td>{{ $asal }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Surat</td>
                        <td>:</td>
                        <td>{{ $suratMasuk->tgl_surat ? $suratMasuk->tgl_surat->translatedFormat('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Diterima</td>
                        <td>:</td>
                        <td>{{ $tglTerima }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><span class="status-badge {{ $st['cls'] }}">{{ $st['label'] }}</span></td>
                    </tr>
                </table>
            </div>

            <div class="qr-section">
                <div class="qr-box" id="qr1"></div>
                <div class="qr-label">Scan untuk cek<br>status surat</div>
            </div>
        </div>

        <div class="signature-area">
            <div class="sig-box">
                <div class="sig-place">{{ $tglMalang }}</div>
                <div class="sig-title">a.n. Kepala Cabang Dinas Pendidikan<br>Wilayah Kabupaten Malang<br>Staf Tata Usaha,</div>
                <div class="sig-name">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</div>
                <div class="sig-nip">NIP. ___________________________</div>
            </div>
            <div class="sig-box">
                <div class="sig-place">{{ $tglMalang }}</div>
                <div class="sig-title">Yang Menerima,<br><br>&nbsp;</div>
                <div class="sig-name">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</div>
                <div class="sig-nip">Nama Jelas</div>
            </div>
        </div>

        @if($trackingUrl)
        <div class="tracking-note">
            Link tracking: {{ $trackingUrl }}
        </div>
        @endif
    </div>

    {{-- ── GARIS POTONG ── --}}
    <div class="cut-line">✂ &nbsp; POTONG DI SINI &nbsp; ✂</div>

    {{-- ── LEMBAR 2 (arsip kantor) ── --}}
    <div class="receipt" id="receipt-2">

        <div class="receipt-header">
            <img src="{{ asset('images/jatim.png') }}" alt="Logo Jawa Timur" class="logo">
            <div class="instansi-wrap">
                <div class="baris-kecil">Pemerintah Provinsi Jawa Timur</div>
                <div class="baris-dinas">Dinas Pendidikan</div>
                <div class="baris-besar">Cabang Dinas Wilayah Kabupaten Malang</div>
                <div class="baris-alamat">
                    Jalan Simpang Ijen Nomor 2, Oro-oro Dowo, Klojen, Malang, Jawa Timur 65119<br>
                    Telepon/Faksimile (0341) 5081868 &nbsp;|&nbsp; cabdinmalang@gmail.com
                </div>
            </div>
        </div>

        <div class="receipt-title">
            Tanda Terima Surat Masuk
            <span style="font-size:8pt; font-weight:400; text-transform:none; letter-spacing:0;">(Arsip)</span>
        </div>

        <div class="receipt-body">
            <div class="receipt-details">
                <table class="detail-table">
                    <tr>
                        <td>Nomor Agenda</td>
                        <td>:</td>
                        <td>{{ $suratMasuk->nomor_agenda ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Surat</td>
                        <td>:</td>
                        <td><strong>{{ $suratMasuk->nomor_surat }}</strong></td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $suratMasuk->perihal ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Dari / Pengirim</td>
                        <td>:</td>
                        <td>{{ $asal }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Surat</td>
                        <td>:</td>
                        <td>{{ $suratMasuk->tgl_surat ? $suratMasuk->tgl_surat->translatedFormat('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Diterima</td>
                        <td>:</td>
                        <td>{{ $tglTerima }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><span class="status-badge {{ $st['cls'] }}">{{ $st['label'] }}</span></td>
                    </tr>
                </table>
            </div>

            <div class="qr-section">
                <div class="qr-box" id="qr2"></div>
                <div class="qr-label">Scan untuk cek<br>status surat</div>
            </div>
        </div>

        <div class="signature-area">
            <div class="sig-box">
                <div class="sig-place">{{ $tglMalang }}</div>
                <div class="sig-title">a.n. Kepala Cabang Dinas Pendidikan<br>Wilayah Kabupaten Malang<br>Staf Tata Usaha,</div>
                <div class="sig-name">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</div>
                <div class="sig-nip">NIP. ___________________________</div>
            </div>
            <div class="sig-box">
                <div class="sig-place">{{ $tglMalang }}</div>
                <div class="sig-title">Yang Menerima,<br><br>&nbsp;</div>
                <div class="sig-name">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</div>
                <div class="sig-nip">Nama Jelas</div>
            </div>
        </div>

        @if($trackingUrl)
        <div class="tracking-note">
            Link tracking: {{ $trackingUrl }}
        </div>
        @endif
    </div>

</div>{{-- end .page-wrapper --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    var trackingUrl = @json($trackingUrl ?? '');

    function makeQR(elementId, url) {
        var el = document.getElementById(elementId);
        if (!el) return;
        if (!url) {
            el.innerHTML = '<span style="font-size:7pt;color:#94a3b8;text-align:center;padding:4px;">Tidak ada<br>link tracking</span>';
            return;
        }
        new QRCode(el, { text: url, width: 76, height: 76, correctLevel: QRCode.CorrectLevel.M });
    }

    makeQR('qr1', trackingUrl);
    makeQR('qr2', trackingUrl);
</script>

</body>
</html>
