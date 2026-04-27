<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Informasi - E-Cabdin</title>
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

        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; height: 68px;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 24px oklch(22% 0.06 250 / 0.06);
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-logo { width: 40px; height: 40px; border-radius: 10px; background: var(--navy); display: flex; align-items: center; justify-content: center; }
        .nav-logo svg { width: 22px; height: 22px; }
        .nav-brand-title { font-size: 13px; font-weight: 700; color: var(--navy); }
        .nav-brand-sub { font-size: 10px; color: var(--text-muted); }
        .nav-back { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--text-muted); padding: 8px 16px; border-radius: 8px; border: 1.5px solid var(--border); transition: all 0.2s; }
        .nav-back:hover { color: var(--blue); border-color: var(--blue); }

        .hero-bar { background: var(--navy); padding: 48px 48px 56px; }
        .hero-inner { max-width: 1100px; margin: 0 auto; }
        .hero-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 12px; }
        .hero-title { font-size: clamp(28px, 3.5vw, 42px); font-weight: 800; color: var(--white); letter-spacing: -0.02em; }

        .page-wrap { max-width: 1100px; margin: 0 auto; padding: 56px 48px 80px; }

        .berita-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .berita-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .berita-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px oklch(22% 0.06 250 / 0.09); }
        .berita-thumb {
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, oklch(22% 0.06 250), oklch(42% 0.14 245));
            overflow: hidden; display: flex; align-items: center; justify-content: center;
        }
        .berita-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .berita-body { padding: 20px; }
        .berita-date { font-size: 11px; color: var(--text-muted); margin-bottom: 8px; }
        .berita-title { font-size: 15px; font-weight: 700; color: var(--navy); line-height: 1.4; margin-bottom: 10px; }
        .berita-excerpt { font-size: 13px; color: var(--text-muted); line-height: 1.65; margin-bottom: 16px; }
        .berita-read { font-size: 12.5px; font-weight: 600; color: var(--blue); display: inline-flex; align-items: center; gap: 4px; }

        .pagination-wrap { display: flex; justify-content: center; margin-top: 48px; }
        .pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; }
        .pagination-wrap .page-item .page-link { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1.5px solid var(--border); color: var(--text-muted); transition: all 0.2s; }
        .pagination-wrap .page-item.active .page-link { background: var(--navy); border-color: var(--navy); color: var(--white); }
        .pagination-wrap .page-item .page-link:hover { border-color: var(--blue); color: var(--blue); }

        .empty { text-align: center; padding: 80px 0; color: var(--text-muted); }
        .empty-icon { font-size: 48px; margin-bottom: 16px; }

        footer { background: var(--navy); color: oklch(70% 0.03 240); padding: 32px 48px; }
        .footer-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
        .footer-copy { font-size: 12px; color: oklch(55% 0.03 240); }
        .footer-link { font-size: 13px; font-weight: 600; color: oklch(70% 0.03 240); transition: color 0.2s; }
        .footer-link:hover { color: var(--gold); }

        @media (max-width: 900px) {
            .navbar, .hero-bar, footer { padding-left: 20px; padding-right: 20px; }
            .page-wrap { padding: 40px 20px 60px; }
            .berita-grid { grid-template-columns: 1fr; }
            .footer-inner { flex-direction: column; gap: 12px; text-align: center; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('landing') }}" class="nav-brand">
        <div class="nav-logo">
            <svg viewBox="0 0 22 22" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 2L2 7l9 5 9-5-9-5z"/>
                <path d="M2 12l9 5 9-5"/>
                <path d="M2 17l9 5 9-5"/>
            </svg>
        </div>
        <div>
            <div class="nav-brand-title">E-Cabdin Pendidikan</div>
            <div class="nav-brand-sub">Kab. Malang · Jawa Timur</div>
        </div>
    </a>
    <a href="{{ route('landing') }}" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Beranda
    </a>
</nav>

<div class="hero-bar">
    <div class="hero-inner">
        <div class="hero-eyebrow">Berita &amp; Informasi</div>
        <h1 class="hero-title">Pengumuman &amp; Berita Terkini</h1>
    </div>
</div>

<div class="page-wrap">
    @if($berita->count() > 0)
    <div class="berita-grid">
        @foreach($berita as $item)
        <a href="{{ route('berita.show', $item->id) }}" class="berita-card">
            <div class="berita-thumb">
                @if($item->thumbnail)
                    <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="{{ $item->judul }}">
                @else
                    <svg viewBox="0 0 40 40" fill="none" stroke="white" stroke-width="1.2" width="28" height="28" style="opacity:0.2">
                        <rect x="4" y="4" width="32" height="32" rx="4"/><circle cx="14" cy="14" r="4"/><path d="M4 28l8-8 6 6 5-5 13 9"/>
                    </svg>
                @endif
            </div>
            <div class="berita-body">
                <div class="berita-date">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                <div class="berita-title">{{ $item->judul }}</div>
                <div class="berita-excerpt">{{ Str::limit(strip_tags($item->konten), 120) }}</div>
                <div class="berita-read">Baca selengkapnya &rarr;</div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination-wrap">
        {{ $berita->links() }}
    </div>
    @else
    <div class="empty">
        <div class="empty-icon">📰</div>
        <p style="font-weight:600; font-size:16px; color:var(--navy); margin-bottom:6px;">Belum ada berita</p>
        <p style="font-size:14px;">Belum ada berita yang dipublikasikan.</p>
    </div>
    @endif
</div>

<footer>
    <div class="footer-inner">
        <div class="footer-copy">&copy; {{ date('Y') }} E-Cabdin &mdash; Cabang Dinas Pendidikan Kab. Malang</div>
        <a href="{{ route('landing') }}" class="footer-link">&larr; Kembali ke Beranda</a>
    </div>
</footer>

</body>
</html>
