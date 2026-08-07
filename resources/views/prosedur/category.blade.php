<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategoriProsedur->nama }} - Prosedur E-Cabdin</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0} :root{--blue:#3B6FE8;--purple:#4153f8;--grad:linear-gradient(135deg,#3B6FE8 0%,#78a0f7 50%,#2f9df7 100%);--bg:#F5F6FA;--text:#1A1A2E;--muted:#7A7A9A;--border:#E4E4F0;--white:#fff;--radius:18px} body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--text);line-height:1.6} a{text-decoration:none;color:inherit}
        .navbar{height:56px;padding:0 48px;background:var(--grad);display:flex;align-items:center;justify-content:space-between}.brand{display:flex;align-items:center;gap:10px;color:#fff;font-size:15px;font-weight:800;letter-spacing:.04em}.brand img{width:32px;height:32px;object-fit:contain}.back{display:inline-flex;align-items:center;gap:8px;padding:7px 17px;border:1px solid rgba(255,255,255,.4);border-radius:999px;color:#fff;font-size:13px;font-weight:700;background:rgba(255,255,255,.1)}.back:hover{background:rgba(255,255,255,.22)}
        .hero{background:var(--grad);padding:52px 48px 70px;position:relative;overflow:hidden}.hero::after{content:'';position:absolute;width:360px;height:360px;border-radius:50%;right:-110px;top:-170px;background:rgba(255,255,255,.08)}.hero-inner,.content{max-width:1100px;margin:auto;position:relative;z-index:1}.breadcrumb{display:flex;gap:8px;color:rgba(255,255,255,.68);font-size:12px;margin-bottom:20px}.breadcrumb a:hover{color:#fff}.eyebrow{display:inline-flex;padding:5px 12px;border-radius:999px;border:1px solid rgba(255,255,255,.35);background:rgba(255,255,255,.14);color:#fff;font-size:11px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;margin-bottom:14px}.hero h1{font-size:clamp(28px,4vw,42px);line-height:1.15;color:#fff;letter-spacing:-.03em;max-width:700px}.hero p{margin-top:14px;color:rgba(255,255,255,.8);font-size:15px}.count{margin-top:22px;color:#fff;font-size:13px;font-weight:700}.count b{font-size:18px;margin-right:5px}
        .content{padding:44px 48px 72px}.section-head{display:flex;justify-content:space-between;align-items:end;gap:20px;margin-bottom:22px}.section-head h2{font-size:22px;letter-spacing:-.02em}.section-head p{font-size:13px;color:var(--muted)}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.card{display:flex;flex-direction:column;min-height:230px;padding:24px;background:var(--white);border:1px solid var(--border);border-radius:var(--radius);transition:transform .2s,box-shadow .2s;position:relative;overflow:hidden}.card::before{content:'';position:absolute;left:0;top:0;width:100%;height:3px;background:var(--grad);transform:scaleX(0);transform-origin:left;transition:transform .25s}.card:hover{transform:translateY(-4px);box-shadow:0 16px 34px rgba(59,111,232,.12)}.card:hover::before{transform:scaleX(1)}.num{width:34px;height:34px;display:grid;place-items:center;border-radius:10px;background:rgba(59,111,232,.09);color:var(--purple);font-size:13px;font-weight:800;margin-bottom:18px}.card h3{font-size:16px;line-height:1.42;margin-bottom:10px}.card p{font-size:13px;color:var(--muted);line-height:1.7;display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden}.detail{margin-top:auto;padding-top:16px;color:var(--purple);font-size:13px;font-weight:800}.empty{padding:48px;text-align:center;background:#fff;border:1px dashed var(--border);border-radius:var(--radius);color:var(--muted)}footer{padding:28px 48px;background:#172554;color:rgba(255,255,255,.55);font-size:12px;text-align:center}
        @media(max-width:800px){.navbar,.hero,.content{padding-left:20px;padding-right:20px}.hero{padding-top:40px;padding-bottom:54px}.grid{grid-template-columns:1fr}.section-head{align-items:start;flex-direction:column}footer{padding:24px 20px}}
    </style>
</head>
<body>
    <nav class="navbar"><a href="{{ route('landing') }}" class="brand"><img src="{{ asset('favicon.png') }}" alt="E-Cabdin">E-CABDIN</a><a class="back" href="{{ route('landing') }}#prosedur">← Kembali ke Beranda</a></nav>
    <header class="hero"><div class="hero-inner"><div class="breadcrumb"><a href="{{ route('landing') }}">Beranda</a><span>/</span><a href="{{ route('landing') }}#prosedur">Prosedur</a><span>/</span><span>{{ $kategoriProsedur->nama }}</span></div><span class="eyebrow">Kategori Prosedur</span><h1>{{ $kategoriProsedur->nama }}</h1><p>Pilih prosedur yang Anda perlukan untuk melihat panduan pelayanan secara lengkap.</p><div class="count"><b>{{ $kategoriProsedur->prosedursAktif->count() }}</b> prosedur tersedia</div></div></header>
    @if(str_contains(strtolower($kategoriProsedur->nama), 'dapodik'))
    <section class="content" style="padding-bottom:0">
        <div class="section-head"><div><h2>Jadwal Dapodik</h2><p>Periode layanan Edit PTK dan Tambah PTK.</p></div></div>
        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px">
            @foreach(['edit_ptk' => 'Edit PTK', 'tambah_ptk' => 'Tambah PTK'] as $jenis => $label)
            @php($jadwal = $dapodikJadwals[$jenis] ?? null)
            <article style="padding:24px;background:#fff;border:1px solid var(--border);border-radius:var(--radius)">
                <div style="font-size:11px;font-weight:800;letter-spacing:.09em;text-transform:uppercase;color:var(--purple);margin-bottom:8px">Jadwal Dapodik</div>
                <h3 style="font-size:19px;margin-bottom:14px">{{ $label }}</h3>
                @if($jadwal && ($jadwal->tanggal_mulai || $jadwal->tanggal_selesai))
                    @if($jadwal->tanggal_mulai)<p style="font-size:13px;color:var(--muted);margin-top:7px">Mulai: <strong style="color:var(--text)">{{ $jadwal->tanggal_mulai->translatedFormat('d F Y') }}</strong></p>@endif
                    @if($jadwal->tanggal_selesai)<p style="font-size:13px;color:var(--muted);margin-top:7px">Selesai: <strong style="color:var(--text)">{{ $jadwal->tanggal_selesai->translatedFormat('d F Y') }}</strong></p>@endif
                    @if($jadwal->keterangan)<p style="font-size:12px;color:var(--muted);font-style:italic;margin-top:12px">{{ $jadwal->keterangan }}</p>@endif
                @else
                    <p style="font-size:13px;color:var(--muted);font-style:italic">Jadwal belum tersedia.</p>
                @endif
            </article>
            @endforeach
        </div>
    </section>
    @endif
    <main class="content"><div class="section-head"><div><h2>Prosedur dalam kategori ini</h2><p>Informasi layanan yang tersedia untuk kategori {{ $kategoriProsedur->nama }}.</p></div></div>@if($kategoriProsedur->prosedursAktif->isNotEmpty())<div class="grid">@foreach($kategoriProsedur->prosedursAktif as $item)<a href="{{ route('prosedur.show', $item) }}" class="card"><div class="num">{{ str_pad($item->urutan, 2, '0', STR_PAD_LEFT) }}</div><h3>{{ $item->judul }}</h3><p>{{ $item->deskripsi }}</p><span class="detail">Lihat panduan →</span></a>@endforeach</div>@else<div class="empty">Belum ada prosedur aktif dalam kategori ini.</div>@endif</main>
    <footer>&copy; {{ date('Y') }} E-Cabdin — Cabang Dinas Pendidikan Kab. Malang</footer>
</body>
</html>
