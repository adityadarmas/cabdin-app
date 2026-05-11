<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - E-Cabdin</title>
    <meta name="description" content="{{ Str::limit(strip_tags($berita->konten), 160) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue:       #3B6FE8;
            --purple:     #4153f8;
            --purple-mid: #3f97e0;
            --grad:       linear-gradient(135deg, #3B6FE8 0%, #78a0f7 50%, #2f9df7 100%);
            --bg:         #F5F6FA;
            --bg2:        #EEEEF8;
            --text:       #1A1A2E;
            --text-muted: #7A7A9A;
            --border:     #E4E4F0;
            --white:      #ffffff;
            --ff:         'Plus Jakarta Sans', sans-serif;
            --ff-serif:   'Lora', Georgia, serif;
            --radius:     12px;
            --radius-lg:  20px;
            --radius-pill:100px;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--ff); background: var(--bg); color: var(--text); line-height: 1.6; }
        img { display: block; max-width: 100%; }
        a { text-decoration: none; color: inherit; }

        /* Reading progress bar */
        #reading-progress {
            position: fixed; top: 0; left: 0; height: 3px; width: 0;
            background: var(--grad); z-index: 200; transition: width .1s linear;
        }

        /* Navbar */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; height: 56px;
            background: var(--grad);
            transition: box-shadow .3s;
        }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(59,111,232,.3); }
        .nav-brand { display: flex; align-items: center; gap: 10px; }
        .nav-logo-box {
            width: 32px; height: 32px; border-radius: 8px;
            overflow: hidden; display: flex; align-items: center; justify-content: center;
        }
        .nav-logo-box img { width: 100%; height: 100%; object-fit: contain; }
        .nav-brand-name { font-size: 15px; font-weight: 800; color: white; letter-spacing: .04em; }
        .nav-back {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 13px; font-weight: 600; color: rgba(255,255,255,.85);
            padding: 7px 18px; border-radius: var(--radius-pill);
            border: 1.5px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.12);
            transition: background .2s, color .2s;
        }
        .nav-back:hover { background: rgba(255,255,255,.22); color: white; }
        .nav-back svg { width: 15px; height: 15px; }

        /* Hero */
        .hero-bar {
            background: var(--grad); padding: 88px 48px 56px;
            position: relative; overflow: hidden;
        }
        .hero-bar::before {
            content: ''; position: absolute; border-radius: 50%;
            width: 440px; height: 440px; background: rgba(255,255,255,.05);
            top: -140px; right: -80px; pointer-events: none;
        }
        .hero-bar::after {
            content: ''; position: absolute; border-radius: 50%;
            width: 220px; height: 220px; background: rgba(255,255,255,.04);
            bottom: -60px; left: 60px; pointer-events: none;
        }
        .hero-inner { max-width: 820px; margin: 0 auto; position: relative; z-index: 1; }
        .hero-breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: rgba(255,255,255,.6); margin-bottom: 20px;
        }
        .hero-breadcrumb a { color: rgba(255,255,255,.6); transition: color .2s; }
        .hero-breadcrumb a:hover { color: white; }
        .hero-breadcrumb .sep { opacity: .35; }
        .hero-cat {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
            color: white; background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.3);
            padding: 4px 12px; border-radius: var(--radius-pill); margin-bottom: 16px;
        }
        .hero-cat::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: white; opacity: .85; }
        .hero-title {
            font-size: clamp(22px, 3.2vw, 38px);
            font-weight: 800; line-height: 1.22;
            color: white; letter-spacing: -.02em; margin-bottom: 24px;
        }
        .hero-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 20px; }
        .hero-meta-item {
            display: flex; align-items: center; gap: 6px;
            font-size: 13px; color: rgba(255,255,255,.72);
        }
        .hero-meta-item svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .hero-meta-sep { width: 3px; height: 3px; border-radius: 50%; background: rgba(255,255,255,.35); }

        /* Page layout */
        .page-wrap { max-width: 820px; margin: 0 auto; padding: 0 48px; }

        /* Thumbnail */
        .thumbnail-wrap {
            border-radius: var(--radius-lg); overflow: hidden;
            margin-top: -32px; margin-bottom: 36px;
            box-shadow: 0 24px 64px rgba(59,111,232,.2);
            border: 1px solid var(--border);
        }
        .thumbnail-wrap img { width: 100%; max-height: 480px; object-fit: cover; }
        .no-thumbnail { margin-top: 40px; }

        /* Article card */
        .article-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 52px 60px;
            margin-bottom: 40px;
        }

        /* Article typography */
        .article { color: var(--text); }

        .article > p:first-of-type {
            font-size: 18px; line-height: 1.85; color: #2d3748;
            font-weight: 400; margin-bottom: 24px;
        }
        .article p {
            font-size: 16px; line-height: 1.9; margin-bottom: 22px; color: #2d3748;
        }
        .article h2 {
            font-size: 22px; font-weight: 800; color: var(--text);
            line-height: 1.3; margin: 44px 0 16px;
            padding-bottom: 12px; border-bottom: 2px solid var(--bg2);
            letter-spacing: -.02em;
        }
        .article h3 {
            font-size: 18px; font-weight: 700; color: var(--text);
            line-height: 1.35; margin: 32px 0 12px; letter-spacing: -.01em;
        }
        .article h4 {
            font-size: 15px; font-weight: 700; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .06em;
            margin: 28px 0 10px;
        }
        .article ul, .article ol {
            padding-left: 28px; margin-bottom: 22px;
        }
        .article li { font-size: 16px; line-height: 1.8; margin-bottom: 8px; color: #2d3748; }
        .article ul li::marker { color: var(--blue); }
        .article ol li::marker { color: var(--blue); font-weight: 700; }
        .article strong { font-weight: 700; color: var(--text); }
        .article em { font-style: italic; }
        .article a { color: var(--blue); text-decoration: underline; text-underline-offset: 3px; }
        .article a:hover { color: var(--purple); }
        .article img {
            border-radius: var(--radius); margin: 32px auto;
            border: 1px solid var(--border);
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
        }
        .article figcaption {
            text-align: center; font-size: 13px; color: var(--text-muted);
            margin-top: -20px; margin-bottom: 32px; font-style: italic;
        }
        .article blockquote {
            border-left: 4px solid var(--blue); padding: 18px 24px;
            margin: 32px 0; background: rgba(59,111,232,.04);
            border-radius: 0 var(--radius) var(--radius) 0;
        }
        .article blockquote p {
            font-size: 17px; font-style: italic; color: #4a5568;
            margin-bottom: 0; line-height: 1.75;
        }
        .article hr {
            border: none; border-top: 2px solid var(--bg2);
            margin: 40px 0;
        }
        .article table { width: 100%; border-collapse: collapse; margin: 28px 0; font-size: 14px; border-radius: var(--radius); overflow: hidden; }
        .article thead th {
            background: var(--bg2); font-weight: 700; font-size: 12px;
            text-transform: uppercase; letter-spacing: .05em;
            padding: 12px 16px; text-align: left; border-bottom: 2px solid var(--border);
            color: var(--text-muted);
        }
        .article td { padding: 12px 16px; border-bottom: 1px solid var(--border); color: #2d3748; }
        .article tr:last-child td { border-bottom: none; }
        .article tr:hover td { background: var(--bg); }
        .article pre {
            background: #1e293b; color: #e2e8f0;
            border-radius: var(--radius); padding: 20px 24px;
            overflow-x: auto; font-family: 'Courier New', monospace;
            font-size: 13.5px; line-height: 1.7; margin: 28px 0;
        }
        .article code:not(pre code) {
            background: var(--bg2); color: var(--purple);
            padding: 2px 7px; border-radius: 5px; font-size: 13.5px;
            font-family: 'Courier New', monospace;
        }

        /* Action bar */
        .action-bar {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
            padding: 20px 0 0; border-top: 1px solid var(--border); margin-top: 44px;
        }
        .action-bar-label { font-size: 13px; font-weight: 600; color: var(--text-muted); }
        .action-btns { display: flex; gap: 8px; flex-wrap: wrap; }
        .action-btn {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 12.5px; font-weight: 600;
            padding: 8px 16px; border-radius: var(--radius-pill);
            border: 1.5px solid var(--border); background: white;
            color: var(--text-muted); cursor: pointer;
            transition: all .2s; font-family: inherit;
        }
        .action-btn:hover { border-color: var(--blue); color: var(--blue); background: rgba(59,111,232,.05); }
        .action-btn svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

        /* Related section */
        .related-section { margin-bottom: 72px; }
        .related-header {
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;
        }
        .related-eyebrow {
            display: flex; align-items: center; gap: 10px;
            font-size: 18px; font-weight: 800; color: var(--text); letter-spacing: -.01em;
        }
        .related-eyebrow::before {
            content: ''; display: inline-block; width: 28px; height: 3px;
            background: var(--grad); border-radius: 4px; flex-shrink: 0;
        }
        .related-all { font-size: 13px; font-weight: 600; color: var(--purple); transition: gap .15s; }
        .related-all:hover { text-decoration: underline; }
        .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .related-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            position: relative; display: flex; flex-direction: column;
        }
        .related-card::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--grad); transform: scaleX(0); transform-origin: left;
            transition: transform .3s ease;
        }
        .related-card:hover { transform: translateY(-4px); box-shadow: 0 14px 36px rgba(59,111,232,.1); }
        .related-card:hover::after { transform: scaleX(1); }
        .related-thumb {
            aspect-ratio: 16/9; background: var(--grad);
            overflow: hidden; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .related-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .related-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }
        .related-date {
            font-size: 11px; font-weight: 700; letter-spacing: .07em;
            color: var(--purple); text-transform: uppercase; margin-bottom: 8px;
        }
        .related-name {
            font-size: 14px; font-weight: 700; color: var(--text);
            line-height: 1.45; flex: 1;
        }
        .related-arrow {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 12px; font-weight: 600; color: var(--purple); margin-top: 12px;
        }

        /* Footer */
        footer { background: linear-gradient(160deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%); color: rgba(255,255,255,.7); padding: 48px 48px 28px; }
        .footer-top { display: grid; grid-template-columns: 1.8fr 1fr 1fr; gap: 48px; padding-bottom: 36px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .footer-brand { display: flex; flex-direction: column; gap: 12px; }
        .footer-logo { width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; }
        .footer-name { font-size: 14px; font-weight: 700; color: white; line-height: 1.3; }
        .footer-tagline { font-size: 13px; color: rgba(255,255,255,.5); line-height: 1.6; }
        .footer-contact { margin-top: 4px; display: flex; flex-direction: column; gap: 8px; }
        .footer-contact-item { font-size: 12px; display: flex; align-items: flex-start; gap: 8px; color: rgba(255,255,255,.5); }
        .footer-contact-item svg { flex-shrink: 0; margin-top: 2px; }
        .footer-col-title { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: white; margin-bottom: 16px; }
        .footer-links { display: flex; flex-direction: column; gap: 10px; }
        .footer-links a { font-size: 13px; color: rgba(255,255,255,.5); transition: color .2s; }
        .footer-links a:hover { color: var(--purple-mid); }
        .footer-bottom { display: flex; align-items: center; justify-content: space-between; padding-top: 24px; flex-wrap: wrap; gap: 12px; }
        .footer-copy { font-size: 12px; color: rgba(255,255,255,.3); }
        .footer-back { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: rgba(255,255,255,.5); transition: color .2s; }
        .footer-back:hover { color: var(--purple-mid); }

        /* Print styles */
        @media print {
            .navbar, #reading-progress, .action-bar, .related-section, footer { display: none !important; }
            .hero-bar { padding: 20px 0 24px; background: white !important; }
            .hero-title, .hero-cat, .hero-meta-item { color: #000 !important; }
            .page-wrap { padding: 0; }
            .article-card { border: none; padding: 0; box-shadow: none; }
            body { background: white; }
        }

        @media (max-width: 900px) {
            .navbar { padding: 0 20px; }
            .hero-bar { padding: 76px 20px 44px; }
            .page-wrap { padding: 0 20px; }
            .article-card { padding: 28px 24px; }
            .related-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 28px; }
            footer { padding: 36px 20px 24px; }
        }
        @media (max-width: 600px) {
            .hero-title { font-size: 20px; }
            .article-card { padding: 24px 18px; }
            .related-grid { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<!-- Reading progress -->
<div id="reading-progress"></div>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="{{ route('landing') }}" class="nav-brand">
        <div class="nav-logo-box"><img src="{{ asset('favicon.png') }}" alt="E-Cabdin"></div>
        <span class="nav-brand-name">E-CABDIN</span>
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
        <div class="hero-breadcrumb">
            <a href="{{ route('landing') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('landing') }}#berita">Berita</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,.88);">{{ Str::limit($berita->judul, 45) }}</span>
        </div>
        <span class="hero-cat">Berita &amp; Informasi</span>
        <h1 class="hero-title">{{ $berita->judul }}</h1>
        <div class="hero-meta">
            <div class="hero-meta-item">
                <svg viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
            </div>
            <div class="hero-meta-sep"></div>
            <div class="hero-meta-item">
                <svg viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Admin Cabdin
            </div>
            <div class="hero-meta-sep"></div>
            <div class="hero-meta-item" id="read-time-wrap" style="display:none;">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span id="read-time"></span>
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

    <div class="article-card" id="article-card">
        <article class="article" id="article-content">
            {!! $berita->konten !!}
        </article>

        <div class="action-bar">
            <span class="action-bar-label">Bagikan artikel ini</span>
            <div class="action-btns">
                <button class="action-btn" id="copy-btn" onclick="copyLink()">
                    <svg viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Salin Tautan
                </button>
                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' — ' . url()->current()) }}" target="_blank" rel="noopener" class="action-btn">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                    WhatsApp
                </a>
                <button class="action-btn" onclick="window.print()">
                    <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak
                </button>
            </div>
        </div>
    </div>

    @if($related->count() > 0)
    <div class="related-section">
        <div class="related-header">
            <div class="related-eyebrow">Berita Lainnya</div>
            <a href="{{ route('landing') }}#berita" class="related-all">Lihat Semua &rarr;</a>
        </div>
        <div class="related-grid">
            @foreach($related as $item)
            <a href="{{ route('berita.show', $item->id) }}" class="related-card">
                <div class="related-thumb">
                    @if($item->thumbnail)
                        <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="{{ $item->judul }}">
                    @else
                        <svg viewBox="0 0 40 40" fill="none" stroke="white" stroke-width="1.2" width="28" height="28" style="opacity:0.22">
                            <rect x="4" y="4" width="32" height="32" rx="4"/><circle cx="14" cy="14" r="4"/><path d="M4 28l8-8 6 6 5-5 13 9"/>
                        </svg>
                    @endif
                </div>
                <div class="related-body">
                    <div class="related-date">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</div>
                    <div class="related-name">{{ $item->judul }}</div>
                    <div class="related-arrow">Baca selengkapnya &rarr;</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<!-- FOOTER -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo">
                <svg viewBox="0 0 22 22" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22">
                    <path d="M11 2L2 7l9 5 9-5-9-5z"/>
                    <path d="M2 12l9 5 9-5"/>
                    <path d="M2 17l9 5 9-5"/>
                </svg>
            </div>
            <div class="footer-name">E-Cabdin<br/>Kab. Malang · Jawa Timur</div>
            <div class="footer-tagline">Melayani dengan tulus, mendidik untuk masa depan bangsa yang lebih cerah.</div>
            <div class="footer-contact">
                <div class="footer-contact-item">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M8 1C5.2 1 3 3.2 3 6c0 4 5 9 5 9s5-5 5-9c0-2.8-2.2-5-5-5zm0 7a2 2 0 100-4 2 2 0 000 4z"/></svg>
                    Jl. Simpang Ijen No. 2, Klojen, Malang 65119
                </div>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M2 4a1 1 0 011-1h10a1 1 0 011 1v8a1 1 0 01-1 1H3a1 1 0 01-1-1V4zm0 0l6 5 6-5"/></svg>
                    cabdinkabmalang@gmail.com
                </div>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Navigasi</div>
            <div class="footer-links">
                <a href="{{ route('landing') }}">Beranda</a>
                <a href="{{ route('landing') }}#layanan">Layanan</a>
                <a href="{{ route('landing') }}#prosedur">Prosedur</a>
                <a href="{{ route('landing') }}#berita">Berita</a>
                <a href="{{ route('landing') }}#staff">Organisasi</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Tautan</div>
            <div class="footer-links">
                <a href="{{ route('login') }}">Masuk Sistem</a>
                <a href="#">Dapodik</a>
                <a href="#">e-PPDB</a>
                <a href="#">SIPTK</a>
                <a href="#">Disdik Jatim</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-copy">&copy; {{ date('Y') }} E-Cabdin &mdash; Cabang Dinas Pendidikan Kab. Malang. All rights reserved.</div>
        <a href="{{ route('landing') }}" class="footer-back">&larr; Kembali ke Beranda</a>
    </div>
</footer>

<script>
    // Navbar scroll shadow
    const nav = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 20);
        updateProgress();
    });

    // Reading progress bar
    const progressBar = document.getElementById('reading-progress');
    function updateProgress() {
        const card = document.getElementById('article-card');
        if (!card) return;
        const start = card.offsetTop - window.innerHeight * 0.3;
        const end   = card.offsetTop + card.offsetHeight - window.innerHeight * 0.7;
        const pct   = Math.min(100, Math.max(0, (window.scrollY - start) / (end - start) * 100));
        progressBar.style.width = pct + '%';
    }

    // Estimated reading time
    (function() {
        var text = document.getElementById('article-content').innerText || '';
        var words = text.trim().split(/\s+/).filter(Boolean).length;
        var mins  = Math.max(1, Math.round(words / 200));
        var el    = document.getElementById('read-time');
        if (el) {
            el.textContent = mins + ' menit baca';
            document.getElementById('read-time-wrap').style.display = 'flex';
        }
    })();

    // Copy link
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            var btn = document.getElementById('copy-btn');
            var orig = btn.innerHTML;
            btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="20 6 9 17 4 12"/></svg> Tersalin!';
            btn.style.borderColor = '#22c55e';
            btn.style.color = '#16a34a';
            btn.style.background = '#f0fdf4';
            setTimeout(function() {
                btn.innerHTML = orig;
                btn.style.borderColor = '';
                btn.style.color = '';
                btn.style.background = '';
            }, 2000);
        });
    }
</script>
</body>
</html>
