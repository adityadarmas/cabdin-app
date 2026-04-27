<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $prosedur->judul }} - E-Cabdin</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: oklch(22% 0.06 250);
            --blue: oklch(45% 0.18 245);
            --gold: oklch(68% 0.16 75);
            --bg: oklch(98% 0.006 240);
            --bg2: oklch(96% 0.008 240);
            --text: oklch(16% 0.025 250);
            --text-muted: oklch(50% 0.02 250);
            --border: oklch(88% 0.012 240);
            --white: #ffffff;
            --ff: 'Plus Jakarta Sans', sans-serif;
            --radius: 12px;
            --radius-lg: 20px;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--ff); background: var(--bg); color: var(--text); line-height: 1.6; }
        img { display: block; max-width: 100%; }
        a { text-decoration: none; color: inherit; }

        /* Navbar */
        .navbar {
            position: sticky; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; height: 68px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 24px oklch(22% 0.06 250 / 0.06);
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-logo {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--navy); display: flex; align-items: center; justify-content: center;
        }
        .nav-logo svg { width: 22px; height: 22px; }
        .nav-brand-text { display: flex; flex-direction: column; }
        .nav-brand-title { font-size: 13px; font-weight: 700; color: var(--navy); line-height: 1.2; }
        .nav-brand-sub { font-size: 10px; color: var(--text-muted); letter-spacing: 0.05em; }
        .nav-back {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 13px; font-weight: 600; color: var(--text-muted);
            padding: 8px 16px; border-radius: 8px; border: 1.5px solid var(--border);
            transition: all 0.2s;
        }
        .nav-back:hover { color: var(--blue); border-color: var(--blue); }

        /* Hero */
        .hero-bar {
            background: linear-gradient(135deg, oklch(22% 0.06 250), oklch(32% 0.10 245));
            padding: 48px 48px 48px;
            position: relative; overflow: hidden;
        }
        .hero-bar::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 300px; height: 300px; border-radius: 50%;
            background: oklch(45% 0.18 245 / 0.12); pointer-events: none;
        }
        .hero-inner { max-width: 900px; margin: 0 auto; position: relative; display: flex; gap: 48px; align-items: flex-start; }
        .hero-num {
            font-size: 80px; font-weight: 800; color: oklch(100% 0 0 / 0.08);
            line-height: 1; letter-spacing: -4px; flex-shrink: 0;
            font-variant-numeric: tabular-nums;
        }
        .hero-content { flex: 1; }
        .hero-cat {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--gold); margin-bottom: 14px;
        }
        .hero-title {
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 800; line-height: 1.2;
            color: var(--white); letter-spacing: -0.02em; margin-bottom: 16px;
        }
        .hero-meta { display: flex; align-items: center; gap: 16px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 100px;
            background: oklch(100% 0 0 / 0.1); border: 1px solid oklch(100% 0 0 / 0.15);
            font-size: 12px; font-weight: 600; color: oklch(85% 0.04 240);
        }

        /* Layout */
        .page-layout {
            max-width: 900px; margin: 0 auto;
            padding: 48px 48px 64px;
            display: grid; grid-template-columns: 1fr 280px; gap: 40px;
            align-items: start;
        }

        /* Content */
        .content-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 40px; min-height: 300px;
        }
        .content-label {
            font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--blue); margin-bottom: 16px;
        }
        .content-body {
            font-size: 15px; line-height: 1.85; color: var(--text);
            white-space: pre-line;
        }
        .content-body p { margin-bottom: 16px; }

        /* Sidebar */
        .sidebar { display: flex; flex-direction: column; gap: 20px; }

        /* Info card */
        .info-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 24px;
        }
        .info-card-title { font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 16px; }
        .info-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: oklch(45% 0.18 245 / 0.08);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .info-icon svg { width: 15px; height: 15px; stroke: var(--blue); fill: none; stroke-width: 1.8; }
        .info-val-label { font-size: 10px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; }
        .info-val { font-size: 13px; font-weight: 600; color: var(--navy); }

        /* Related */
        .related-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 20px;
        }
        .related-title { font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 14px; }
        .related-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 10px 0; border-bottom: 1px solid var(--border);
            transition: transform 0.15s;
        }
        .related-item:last-child { border-bottom: none; padding-bottom: 0; }
        .related-item:hover { transform: translateX(3px); }
        .related-num {
            width: 28px; height: 28px; border-radius: 8px;
            background: oklch(45% 0.18 245 / 0.08); color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; flex-shrink: 0;
        }
        .related-item.active .related-num { background: var(--blue); color: var(--white); }
        .related-item-title { font-size: 12.5px; font-weight: 600; color: var(--navy); line-height: 1.4; }
        .related-item.active .related-item-title { color: var(--blue); }

        /* Back button */
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 24px; border-radius: 10px;
            border: 1.5px solid var(--border); background: var(--white);
            font-size: 14px; font-weight: 600; color: var(--text);
            transition: all 0.2s; margin-top: 8px;
        }
        .back-btn:hover { border-color: var(--blue); color: var(--blue); transform: translateX(-3px); }

        /* Footer */
        footer { background: var(--navy); color: oklch(70% 0.03 240); padding: 32px 48px; }
        .footer-inner { max-width: 900px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
        .footer-copy { font-size: 12px; color: oklch(55% 0.03 240); }
        .footer-link { font-size: 13px; font-weight: 600; color: oklch(70% 0.03 240); transition: color 0.2s; }
        .footer-link:hover { color: var(--gold); }

        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }
            .hero-bar { padding: 32px 20px; }
            .hero-inner { flex-direction: column; gap: 16px; }
            .hero-num { display: none; }
            .page-layout { grid-template-columns: 1fr; padding: 32px 20px 48px; }
            .footer-inner { flex-direction: column; gap: 12px; text-align: center; }
            footer { padding: 28px 20px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('landing') }}" class="nav-brand">
        <div class="nav-logo">
            <svg viewBox="0 0 22 22" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 2L2 7l9 5 9-5-9-5z"/>
                <path d="M2 12l9 5 9-5"/>
                <path d="M2 17l9 5 9-5"/>
            </svg>
        </div>
        <div class="nav-brand-text">
            <span class="nav-brand-title">E-Cabdin Pendidikan</span>
            <span class="nav-brand-sub">Kab. Malang · Jawa Timur</span>
        </div>
    </a>
    <a href="{{ route('landing') }}#prosedur" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Kembali
    </a>
</nav>

<!-- HERO -->
<div class="hero-bar">
    <div class="hero-inner">
        <div class="hero-num">{{ str_pad($prosedur->urutan, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="hero-content">
            <div class="hero-cat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Prosedur Pelayanan
            </div>
            <h1 class="hero-title">{{ $prosedur->judul }}</h1>
            <div class="hero-meta">
                @if($prosedur->kategori)
                <div class="hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="12" height="12"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                    {{ $prosedur->kategori->nama }}
                </div>
                @endif
                <div class="hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="12" height="12"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Prosedur #{{ $prosedur->urutan }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LAYOUT -->
<div class="page-layout">

    <!-- MAIN CONTENT -->
    <div>
        <div class="content-card">
            <div class="content-label">Panduan Lengkap</div>
            <div class="content-body">{{ $prosedur->deskripsi }}</div>
        </div>

        <a href="{{ route('landing') }}#prosedur" class="back-btn" style="margin-top:24px; display:inline-flex;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Kembali ke Prosedur
        </a>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <!-- Info -->
        <div class="info-card">
            <div class="info-card-title">Informasi Prosedur</div>
            @if($prosedur->kategori)
            <div class="info-row">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                </div>
                <div>
                    <div class="info-val-label">Kategori</div>
                    <div class="info-val">{{ $prosedur->kategori->nama }}</div>
                </div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                </div>
                <div>
                    <div class="info-val-label">Urutan</div>
                    <div class="info-val">Prosedur ke-{{ $prosedur->urutan }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="info-val-label">Status</div>
                    <div class="info-val" style="color: oklch(50% 0.18 145);">Aktif</div>
                </div>
            </div>
        </div>

        <!-- Prosedur lain dalam kategori yang sama -->
        @if($related->count() > 0)
        <div class="related-card">
            <div class="related-title">Prosedur Lainnya</div>
            @foreach($related as $item)
            <a href="{{ route('prosedur.show', $item->id) }}" class="related-item {{ $item->id === $prosedur->id ? 'active' : '' }}">
                <div class="related-num">{{ str_pad($item->urutan, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="related-item-title">{{ $item->judul }}</div>
            </a>
            @endforeach
        </div>
        @endif

        <!-- Kontak -->
        <div class="info-card">
            <div class="info-card-title">Butuh Bantuan?</div>
            <p style="font-size:13px; color:var(--text-muted); line-height:1.6; margin-bottom:14px;">
                Hubungi kami jika ada pertanyaan terkait prosedur pelayanan.
            </p>
            <div class="info-row" style="margin-bottom:8px;">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="info-val-label">Email</div>
                    <div class="info-val" style="font-size:12px;">cabdinkabmalang@gmail.com</div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div class="footer-copy">&copy; {{ date('Y') }} E-Cabdin &mdash; Cabang Dinas Pendidikan Kab. Malang</div>
        <a href="{{ route('landing') }}" class="footer-link">&larr; Kembali ke Beranda</a>
    </div>
</footer>

</body>
</html>
