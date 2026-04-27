<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - E-Cabdin</title>
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
        .nav-back svg { width: 16px; height: 16px; }

        /* Hero */
        .hero-bar {
            background: var(--navy);
            padding: 48px 48px 64px;
        }
        .hero-inner { max-width: 860px; margin: 0 auto; }
        .hero-cat {
            display: inline-block; font-size: 11px; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--gold); margin-bottom: 16px;
        }
        .hero-title {
            font-size: clamp(26px, 3.5vw, 42px);
            font-weight: 800; line-height: 1.2;
            color: var(--white); letter-spacing: -0.02em;
            margin-bottom: 20px;
        }
        .hero-meta { display: flex; align-items: center; gap: 20px; font-size: 13px; color: oklch(70% 0.04 240); }
        .hero-meta-item { display: flex; align-items: center; gap: 6px; }
        .hero-meta-item svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.5; }

        /* Content area */
        .page-wrap { max-width: 860px; margin: 0 auto; padding: 0 48px; }

        /* Thumbnail */
        .thumbnail-wrap {
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-top: -32px;
            box-shadow: 0 20px 60px oklch(22% 0.06 250 / 0.2);
            margin-bottom: 48px;
        }
        .thumbnail-wrap img { width: 100%; max-height: 480px; object-fit: cover; }
        .no-thumbnail { margin-top: 48px; }

        /* Article */
        .article {
            font-size: 16px; line-height: 1.85; color: var(--text);
            margin-bottom: 64px;
        }
        .article h1, .article h2, .article h3, .article h4 {
            color: var(--navy); font-weight: 700; line-height: 1.3; margin: 32px 0 12px;
        }
        .article h2 { font-size: 24px; }
        .article h3 { font-size: 20px; }
        .article p { margin-bottom: 18px; }
        .article ul, .article ol { padding-left: 24px; margin-bottom: 18px; }
        .article li { margin-bottom: 6px; }
        .article strong { font-weight: 700; color: var(--navy); }
        .article a { color: var(--blue); text-decoration: underline; }
        .article img { border-radius: var(--radius); margin: 24px 0; }
        .article blockquote {
            border-left: 4px solid var(--blue); padding: 16px 20px;
            margin: 24px 0; background: oklch(45% 0.18 245 / 0.05);
            border-radius: 0 var(--radius) var(--radius) 0;
            font-style: italic; color: var(--text-muted);
        }

        /* Divider */
        .divider { height: 1px; background: var(--border); margin: 0 0 48px; }

        /* Related */
        .related-title {
            font-size: 20px; font-weight: 800; color: var(--navy);
            letter-spacing: -0.02em; margin-bottom: 24px;
        }
        .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 64px; }
        .related-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .related-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px oklch(22% 0.06 250 / 0.09); }
        .related-thumb {
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, oklch(22% 0.06 250), oklch(42% 0.14 245));
            overflow: hidden; display: flex; align-items: center; justify-content: center;
        }
        .related-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .related-body { padding: 16px; }
        .related-date { font-size: 11px; color: var(--text-muted); margin-bottom: 6px; }
        .related-name { font-size: 13.5px; font-weight: 700; color: var(--navy); line-height: 1.4; }

        /* Footer */
        footer { background: var(--navy); color: oklch(70% 0.03 240); padding: 32px 48px; }
        .footer-inner { max-width: 860px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
        .footer-copy { font-size: 12px; color: oklch(55% 0.03 240); }
        .footer-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; font-weight: 600; color: oklch(70% 0.03 240);
            transition: color 0.2s;
        }
        .footer-back:hover { color: var(--gold); }

        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }
            .hero-bar { padding: 32px 20px 48px; }
            .page-wrap { padding: 0 20px; }
            .related-grid { grid-template-columns: 1fr; }
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
    <a href="{{ route('landing') }}#berita" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Kembali ke Beranda
    </a>
</nav>

<!-- HERO -->
<div class="hero-bar">
    <div class="hero-inner">
        <span class="hero-cat">Berita &amp; Informasi</span>
        <h1 class="hero-title">{{ $berita->judul }}</h1>
        <div class="hero-meta">
            <div class="hero-meta-item">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
            </div>
            <div class="hero-meta-item">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Admin Cabdin
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="page-wrap">
    @if($berita->thumbnail)
    <div class="thumbnail-wrap">
        <img src="{{ asset('storage/'.$berita->thumbnail) }}" alt="{{ $berita->judul }}">
    </div>
    @else
    <div class="no-thumbnail"></div>
    @endif

    <article class="article">
        {!! $berita->konten !!}
    </article>

    @if($related->count() > 0)
    <div class="divider"></div>
    <div class="related-title">Berita Lainnya</div>
    <div class="related-grid">
        @foreach($related as $item)
        <a href="{{ route('berita.show', $item->id) }}" class="related-card">
            <div class="related-thumb">
                @if($item->thumbnail)
                    <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="{{ $item->judul }}">
                @else
                    <svg viewBox="0 0 40 40" fill="none" stroke="white" stroke-width="1.2" width="28" height="28" style="opacity:0.2">
                        <rect x="4" y="4" width="32" height="32" rx="4"/><circle cx="14" cy="14" r="4"/><path d="M4 28l8-8 6 6 5-5 13 9"/>
                    </svg>
                @endif
            </div>
            <div class="related-body">
                <div class="related-date">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</div>
                <div class="related-name">{{ $item->judul }}</div>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div class="footer-copy">&copy; {{ date('Y') }} E-Cabdin &mdash; Cabang Dinas Pendidikan Kab. Malang</div>
        <a href="{{ route('landing') }}" class="footer-back">
            &larr; Kembali ke Beranda
        </a>
    </div>
</footer>

</body>
</html>
