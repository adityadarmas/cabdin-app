<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Cabdin - Cabang Dinas Pendidikan</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            --radius:     12px;
            --radius-lg:  20px;
            --radius-pill:100px;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--ff); background: var(--bg); color: var(--text); line-height: 1.6; }
        img { display: block; max-width: 100%; }
        a { text-decoration: none; color: inherit; }
        [x-cloak] { display: none !important; }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
        .reveal.visible { opacity: 1; transform: none; }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }
        .reveal-delay-4 { transition-delay: .4s; }

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
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .nav-logo-box img { width: 100%; height: 100%; object-fit: contain; }
        .nav-brand-name { font-size: 15px; font-weight: 800; color: white; letter-spacing: .04em; }
        .nav-links { display: flex; gap: 28px; }
        .nav-links a { font-size: 13.5px; font-weight: 600; color: rgba(255,255,255,.8); transition: color .2s; }
        .nav-links a:hover { color: white; }
        .nav-cta {
            font-size: 13px; font-weight: 700; padding: 8px 20px;
            background: rgba(255,255,255,.18); color: white; border-radius: var(--radius-pill);
            border: 1.5px solid rgba(255,255,255,.35);
            transition: background .2s;
        }
        .nav-cta:hover { background: rgba(255,255,255,.28); }

        /* Hero */
        .hero {
            min-height: 100vh;
            background: var(--grad);
            display: grid; grid-template-columns: 1fr 1fr;
            align-items: center;
            padding: 100px 48px 72px; gap: 56px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; border-radius: 50%;
            width: 500px; height: 500px;
            background: rgba(255,255,255,.05);
            top: -160px; right: -80px; pointer-events: none;
        }
        .hero::after {
            content: ''; position: absolute; border-radius: 50%;
            width: 320px; height: 320px;
            background: rgba(255,255,255,.04);
            bottom: -100px; left: 120px; pointer-events: none;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 14px; border-radius: var(--radius-pill);
            background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
            font-size: 12px; font-weight: 700; color: white;
            letter-spacing: .04em; margin-bottom: 22px;
        }
        .hero-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: white; opacity: .8; }
        .hero-title {
            font-size: clamp(34px, 4.5vw, 56px);
            font-weight: 800; line-height: 1.1;
            color: white; letter-spacing: -.02em; margin-bottom: 18px;
        }
        .hero-title span { color: rgba(255,255,255,.9); }
        .hero-desc { font-size: 15.5px; color: rgba(255,255,255,.8); line-height: 1.75; max-width: 480px; margin-bottom: 32px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-primary {
            padding: 13px 26px; border-radius: var(--radius-pill);
            background: white; color: var(--purple);
            font-size: 14px; font-weight: 700;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            display: inline-block;
        }
        .btn-primary:hover { opacity: .92; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.15); }
        .btn-outline {
            padding: 13px 26px; border-radius: var(--radius-pill);
            border: 1.5px solid rgba(255,255,255,.45); background: transparent;
            font-size: 14px; font-weight: 700; color: white;
            transition: background .2s, transform .15s; display: inline-block;
        }
        .btn-outline:hover { background: rgba(255,255,255,.12); transform: translateY(-2px); }
        .btn-grad {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px; border-radius: var(--radius-pill);
            background: var(--grad); color: white;
            font-size: 14px; font-weight: 700;
            transition: opacity .2s, transform .15s, box-shadow .2s;
        }
        .btn-grad:hover { opacity: .9; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(123,47,247,.3); }
        .btn-secondary {
            padding: 13px 26px; border-radius: var(--radius-pill);
            border: 1.5px solid var(--border); background: transparent;
            font-size: 14px; font-weight: 700; color: var(--text);
            transition: border-color .2s, color .2s, transform .15s; display: inline-block;
        }
        .btn-secondary:hover { border-color: var(--purple); color: var(--purple); transform: translateY(-2px); }
        .hero-stats { display: flex; gap: 0; margin-top: 44px; padding-top: 32px; border-top: 1px solid rgba(255,255,255,.2); }
        .stat-item { padding: 0 24px; display: flex; flex-direction: column; }
        .stat-item:first-child { padding-left: 0; }
        .stat-item:not(:last-child) { border-right: 1px solid rgba(255,255,255,.25); }
        .stat-num { font-size: 28px; font-weight: 800; color: white; letter-spacing: -.03em; line-height: 1; }
        .stat-label { font-size: 11px; font-weight: 600; letter-spacing: .06em; color: rgba(255,255,255,.65); margin-top: 4px; }
        .hero-visual { position: relative; display: flex; align-items: center; justify-content: center; }
        .map-wrap { position: relative; display: flex; align-items: center; justify-content: center; width: 100%; }
        .kab-map {
            width: 100%; max-width: 460px;
            animation: mapEnter .8s cubic-bezier(.16,1,.3,1) .2s both;
            filter: drop-shadow(0 0 40px rgba(255,255,255,.13)) drop-shadow(0 4px 60px rgba(80,130,255,.18));
            overflow: visible;
        }
        @keyframes mapEnter {
            from { opacity: 0; transform: translateX(60px) scale(.9); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }
        .kab-boundary {
            stroke: rgba(255,255,255,.9);
            stroke-width: 2.5;
            stroke-linejoin: round;
            fill-opacity: 0;
            stroke-dasharray: 1850;
            stroke-dashoffset: 1850;
            animation: drawMap 2.2s ease-out .6s forwards;
        }
        @keyframes drawMap {
            0%  { stroke-dashoffset: 1850; fill-opacity: 0; }
            65% { stroke-dashoffset: 0;    fill-opacity: 0; }
            100%{ stroke-dashoffset: 0;    fill-opacity: 1; }
        }
        .enclave-path {
            fill: rgba(255,255,255,.08);
            stroke: rgba(255,255,255,.5);
            stroke-width: 1.4;
            stroke-dasharray: 4,3;
            opacity: 0;
            animation: fadeReveal .5s ease 2.5s forwards;
        }
        .enclave-path.delay { animation-delay: 2.65s; }
        .dot-pulse {
            fill: none;
            stroke: rgba(255,255,255,.7);
            stroke-width: 1.5;
            transform-box: fill-box;
            transform-origin: center;
            animation: pulse 2s ease-out 3.4s infinite;
        }
        @keyframes pulse {
            0%   { transform: scale(1); opacity: .75; }
            100% { transform: scale(4.5); opacity: 0; }
        }
        .city-dot {
            fill: white;
            transform-box: fill-box;
            transform-origin: center;
            opacity: 0;
            transform: scale(0);
        }
        .d1 { animation: dotPop .4s cubic-bezier(.34,1.56,.64,1) 2.8s forwards; }
        .d2 { animation: dotPop .4s cubic-bezier(.34,1.56,.64,1) 2.95s forwards; }
        .d3 { animation: dotPop .4s cubic-bezier(.34,1.56,.64,1) 3.1s forwards; }
        .d4 { animation: dotPop .4s cubic-bezier(.34,1.56,.64,1) 3.2s forwards; }
        .d5 { animation: dotPop .4s cubic-bezier(.34,1.56,.64,1) 3.3s forwards; }
        @keyframes dotPop {
            0%  { opacity: 0; transform: scale(0); }
            60% { opacity: 1; transform: scale(1.45); }
            100%{ opacity: 1; transform: scale(1); }
        }
        .mtn-reveal { opacity: 0; animation: fadeReveal .5s ease 2.75s forwards; }
        .coast-line { opacity: 0; animation: fadeReveal .6s ease 2.6s forwards; }
        .map-lbl    { opacity: 0; animation: fadeReveal .8s ease 2.45s forwards; }
        @keyframes fadeReveal { to { opacity: 1; } }

        /* Section common */
        .section { padding: 88px 48px; }
        .section-alt { background: var(--bg2); }
        .section-header { text-align: center; max-width: 580px; margin: 0 auto 56px; }
        .section-eyebrow {
            display: inline-block; font-size: 11px; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
            color: var(--purple); margin-bottom: 12px;
        }
        .section-title { font-size: clamp(26px, 3.5vw, 38px); font-weight: 800; color: var(--text); letter-spacing: -.02em; line-height: 1.2; margin-bottom: 14px; }
        .section-desc { font-size: 14.5px; color: var(--text-muted); line-height: 1.75; }

        /* Layanan */
        .layanan-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; max-width: 1100px; margin: 0 auto; }
        .layanan-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 32px 26px;
            transition: transform .25s, box-shadow .25s;
            position: relative; overflow: hidden;
        }
        .layanan-card::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--grad); transform: scaleX(0); transform-origin: left;
            transition: transform .3s ease;
        }
        .layanan-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(123,47,247,.1); }
        .layanan-card:hover::after { transform: scaleX(1); }
        .layanan-icon {
            width: 50px; height: 50px; border-radius: 14px;
            background: linear-gradient(135deg, rgba(59,111,232,.1), rgba(123,47,247,.1));
            display: flex; align-items: center; justify-content: center; margin-bottom: 18px;
        }
        .layanan-icon svg { width: 22px; height: 22px; stroke: var(--purple); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .layanan-name { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 9px; }
        .layanan-desc { font-size: 13px; color: var(--text-muted); line-height: 1.7; }

        /* Produk */
        .produk-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; max-width: 1100px; margin: 0 auto; }
        .produk-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
            transition: transform .25s, box-shadow .25s;
        }
        .produk-card:hover { transform: translateY(-4px); box-shadow: 0 14px 36px rgba(123,47,247,.1); }
        .produk-thumb {
            aspect-ratio: 3/2;
            background: var(--bg);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .produk-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .produk-thumb-placeholder {
            display: flex; flex-direction: column; align-items: center; gap: 6px;
            font-size: 10px; color: var(--text-muted); letter-spacing: .06em; text-transform: uppercase;
        }
        .produk-tag {
            position: absolute; top: 10px; left: 10px;
            font-size: 10px; font-weight: 700; letter-spacing: .06em;
            padding: 4px 10px; border-radius: var(--radius-pill);
            background: var(--grad); color: white;
        }
        .produk-body { padding: 16px; }
        .produk-name { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 6px; line-height: 1.3; }
        .produk-school { font-size: 11.5px; color: var(--text-muted); margin-bottom: 4px; }
        .produk-price { font-size: 14px; font-weight: 700; color: var(--purple); }

        /* Prosedur */
        .prosedur-tabs { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-bottom: 40px; }
        .prosedur-tab {
            padding: 8px 20px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 600;
            border: 1.5px solid var(--border); background: white;
            color: var(--text-muted); cursor: pointer; transition: all .2s;
        }
        .prosedur-tab-active { background: var(--grad); border-color: transparent; color: white; }
        .prosedur-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1100px; margin: 0 auto; }
        .prosedur-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 28px;
            display: flex; flex-direction: column;
            transition: transform .25s, box-shadow .25s;
        }
        .prosedur-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(123,47,247,.09); }
        .prosedur-num {
            width: 44px; height: 44px; border-radius: 12px;
            background: var(--grad); color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; margin-bottom: 16px;
        }
        .prosedur-title { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 10px; }
        .prosedur-desc { font-size: 13px; color: var(--text-muted); line-height: 1.7; flex: 1; }
        .prosedur-link { display: inline-flex; align-items: center; gap: 6px; margin-top: 16px; font-size: 13px; font-weight: 600; color: var(--purple); }

        /* Dapodik */
        .dapodik-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 1100px; margin: 0 auto 32px; }
        .dapodik-card { background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; }
        .dapodik-label { font-size: 11px; font-weight: 700; color: var(--purple); letter-spacing: .08em; text-transform: uppercase; margin-bottom: 4px; }
        .dapodik-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 12px; }
        .dapodik-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); margin-bottom: 6px; }

        /* Berita */
        .berita-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 24px; max-width: 1100px; margin: 0 auto; }
        .berita-featured {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden; transition: box-shadow .25s;
        }
        .berita-featured:hover { box-shadow: 0 16px 40px rgba(123,47,247,.08); }
        .berita-featured-img {
            aspect-ratio: 16/8;
            background: var(--grad);
            overflow: hidden; display: flex; align-items: center; justify-content: center;
        }
        .berita-featured-img img { width: 100%; height: 100%; object-fit: cover; }
        .berita-featured-body { padding: 28px; }
        .berita-cat {
            display: inline-block; font-size: 10px; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: var(--purple); background: rgba(123,47,247,.08);
            padding: 3px 10px; border-radius: var(--radius-pill); margin-bottom: 10px;
        }
        .berita-featured-title { font-size: 20px; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 12px; }
        .berita-featured-desc { font-size: 13.5px; color: var(--text-muted); line-height: 1.7; }
        .berita-meta { display: flex; align-items: center; gap: 16px; margin-top: 20px; font-size: 12px; color: var(--text-muted); }
        .berita-read-more { display: inline-flex; align-items: center; gap: 6px; margin-top: 16px; font-size: 13px; font-weight: 600; color: var(--purple); transition: gap .2s; }
        .berita-read-more:hover { gap: 10px; }
        .berita-list { display: flex; flex-direction: column; gap: 14px; }
        .berita-item {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius); padding: 18px 20px;
            display: flex; gap: 16px; align-items: flex-start;
            transition: transform .2s, box-shadow .2s;
        }
        .berita-item:hover { transform: translateX(4px); box-shadow: 0 6px 20px rgba(123,47,247,.07); }
        .berita-item-num { font-size: 26px; font-weight: 800; color: var(--border); min-width: 32px; line-height: 1; }
        .berita-item-content { flex: 1; }
        .berita-item-title { font-size: 13.5px; font-weight: 600; color: var(--text); line-height: 1.4; margin-bottom: 6px; }
        .berita-item-date { font-size: 11px; color: var(--text-muted); }

        /* Org / Staff */
        .org-wrap { max-width: 900px; margin: 0 auto; }
        .org-level { display: flex; justify-content: center; }
        .org-connector-line { width: 2px; height: 32px; background: var(--border); margin: 0 auto; }
        .org-node {
            background: white; border: 1.5px solid var(--border);
            border-radius: 12px; padding: 16px 22px; text-align: center;
            min-width: 160px; max-width: 200px;
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }
        .org-node:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(123,47,247,.1); border-color: var(--purple); }
        .org-node.head { background: var(--grad); border-color: transparent; min-width: 230px; max-width: 280px; }
        .org-node.head .org-node-name { color: white; }
        .org-node.head .org-node-role { color: rgba(255,255,255,.7); }
        .org-node.deputy { background: rgba(107,63,224,.07); border-color: rgba(107,63,224,.3); }
        .org-node.deputy .org-node-name { color: var(--purple-mid); }
        .org-node-avatar {
            width: 44px; height: 44px; border-radius: 50%; margin: 0 auto 10px;
            background: var(--bg2); border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: var(--text-muted);
        }
        .org-node.head .org-node-avatar { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.3); color: white; }
        .org-node-name { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 4px; }
        .org-node-role { font-size: 11px; color: var(--text-muted); font-weight: 500; }
        .org-children { display: flex; gap: 12px; justify-content: center; padding-top: 24px; }

        .staff-tabs { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin: 48px 0 32px; }
        .staff-tab {
            padding: 8px 20px; border-radius: var(--radius-pill); font-size: 13px; font-weight: 600;
            border: 1.5px solid var(--border); background: white;
            color: var(--text-muted); cursor: pointer; transition: all .2s;
        }
        .staff-tab-active { background: var(--grad); border-color: transparent; color: white; }
        .staff-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; max-width: 900px; margin: 0 auto; }
        .staff-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--radius); padding: 16px 20px;
            display: flex; align-items: center; gap: 16px;
            transition: transform .2s, box-shadow .2s;
        }
        .staff-card:hover { transform: translateX(4px); box-shadow: 0 6px 20px rgba(123,47,247,.07); }
        .staff-avatar {
            width: 44px; height: 44px; border-radius: 12px;
            background: var(--grad); color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; flex-shrink: 0;
        }
        .staff-role { font-size: 11px; color: var(--purple); font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
        .staff-name { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 2px; }
        .staff-nip { font-size: 11px; color: var(--text-muted); }

        /* Footer */
        footer { background: linear-gradient(160deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%); color: rgba(255,255,255,.7); padding: 64px 48px 32px; }
        .footer-top { display: grid; grid-template-columns: 1.8fr 1fr 1fr 1fr; gap: 48px; padding-bottom: 48px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .footer-brand { display: flex; flex-direction: column; gap: 16px; }
        .footer-logo { width: 44px; height: 44px; border-radius: 10px; background: rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; }
        .footer-name { font-size: 15px; font-weight: 700; color: white; line-height: 1.3; }
        .footer-tagline { font-size: 13px; color: rgba(255,255,255,.55); line-height: 1.6; }
        .footer-contact { margin-top: 4px; display: flex; flex-direction: column; gap: 8px; }
        .footer-contact-item { font-size: 12.5px; display: flex; align-items: flex-start; gap: 8px; color: rgba(255,255,255,.55); }
        .footer-contact-item svg { flex-shrink: 0; margin-top: 2px; }
        .footer-col-title { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: white; margin-bottom: 18px; }
        .footer-links { display: flex; flex-direction: column; gap: 11px; }
        .footer-links a { font-size: 13px; color: rgba(255,255,255,.55); transition: color .2s; }
        .footer-links a:hover { color: var(--purple-mid); }
        .footer-bottom { display: flex; align-items: center; justify-content: space-between; padding-top: 28px; }
        .footer-copy { font-size: 12px; color: rgba(255,255,255,.35); }

        @media (max-width: 900px) {
            .navbar { padding: 0 20px; }
            .nav-links { display: none; }
            .hero { grid-template-columns: 1fr; padding: 90px 20px 48px; }
            .hero-visual { display: none; }
            .section { padding: 60px 20px; }
            .layanan-grid, .prosedur-grid { grid-template-columns: 1fr; }
            .produk-grid { grid-template-columns: repeat(2, 1fr); }
            .dapodik-grid { grid-template-columns: 1fr; }
            .berita-grid { grid-template-columns: 1fr; }
            .staff-grid { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 28px; }
            .footer-bottom { flex-direction: column; gap: 16px; text-align: center; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="nav-brand">
        <div class="nav-logo-box"><img src="{{ asset('favicon.png') }}" alt="E-Cabdin"></div>
        <span class="nav-brand-name">E-CABDIN</span>
    </div>
    <div class="nav-links">
        <a href="#layanan">Layanan</a>
        <a href="#produk">Produk</a>
        <a href="#prosedur">Prosedur</a>
        <a href="#berita">Berita</a>
        <a href="#staff">Staff</a>
    </div>
    <a href="{{ route('login') }}" class="nav-cta">Masuk</a>
</nav>

<!-- HERO -->
<section class="hero" id="hero">
    <div class="hero-content">
        <div class="hero-badge reveal">
            Pemerintah Provinsi Jawa Timur
        </div>
        <h1 class="hero-title reveal reveal-delay-1">
            Mendidik<br/><span>Generasi</span><br/>Unggul Bangsa
        </h1>
        <p class="hero-desc reveal reveal-delay-2">
            Cabang Dinas Pendidikan Provinsi Jawa Timur Wilayah Kabupaten Malang berkomitmen memberikan layanan pendidikan berkualitas, transparan, dan berorientasi pada kemajuan peserta didik.
        </p>
        <div class="hero-actions reveal reveal-delay-3">
            <a href="#produk" class="btn-primary">Jelajahi Produk</a>
            <a href="#prosedur" class="btn-outline">Panduan Layanan</a>
        </div>
        <div class="hero-stats reveal reveal-delay-4">
            <div class="stat-item">
                <span class="stat-num">{{ $produk->count() }}+</span>
                <span class="stat-label">Produk Aktif</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $berita->count() }}+</span>
                <span class="stat-label">Berita Terkini</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">{{ $kategoriProsedur->sum(fn($k) => $k->prosedursAktif->count()) }}</span>
                <span class="stat-label">Prosedur Layanan</span>
            </div>
        </div>
    </div>
    <div class="hero-visual">
        <div class="map-wrap">
            <svg class="kab-map" viewBox="0 0 360 345" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="kabFill" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="rgba(255,255,255,.22)"/>
                        <stop offset="100%" stop-color="rgba(255,255,255,.05)"/>
                    </linearGradient>
                </defs>

                <!-- Subtle grid lines -->
                <line x1="0" y1="115" x2="360" y2="115" stroke="rgba(255,255,255,.07)" stroke-width="1"/>
                <line x1="0" y1="230" x2="360" y2="230" stroke="rgba(255,255,255,.07)" stroke-width="1"/>
                <line x1="120" y1="0" x2="120" y2="345" stroke="rgba(255,255,255,.07)" stroke-width="1"/>
                <line x1="240" y1="0" x2="240" y2="345" stroke="rgba(255,255,255,.07)" stroke-width="1"/>

                <!-- Outer boundary Kabupaten Malang -->
                <path class="kab-boundary"
                    fill="url(#kabFill)"
                    d="M 55,52
                       C 70,32 100,18 140,12
                       C 170,7 200,9 232,19
                       C 260,29 290,46 315,66
                       C 335,82 348,107 350,136
                       C 352,162 345,192 332,220
                       C 318,250 298,272 272,294
                       C 248,315 218,330 185,337
                       C 155,343 122,337 95,321
                       C 72,308 50,285 35,257
                       C 22,233 18,206 22,179
                       C 26,151 34,125 47,101
                       C 51,85 53,68 55,52 Z"/>

                <!-- Kota Malang enclave -->
                <path class="enclave-path"
                    d="M 165,101 C 175,89 192,84 208,88 C 222,92 230,105 226,119
                       C 222,132 208,140 192,139 C 175,138 163,127 162,113
                       C 161,108 162,104 165,101 Z"/>

                <!-- Kota Batu enclave -->
                <path class="enclave-path delay"
                    d="M 110,89 C 118,77 134,71 148,75 C 161,79 167,91 162,104
                       C 157,115 143,121 129,118 C 114,115 106,103 110,91 Z"/>

                <!-- Mountain symbols -->
                <g class="mtn-reveal">
                    <polygon points="308,91 316,77 324,91" fill="none" stroke="rgba(255,255,255,.72)" stroke-width="1.3" stroke-linejoin="round"/>
                    <text x="316" y="103" text-anchor="middle" fill="rgba(255,255,255,.5)" font-size="6.5" font-family="Plus Jakarta Sans,sans-serif">Semeru</text>
                    <polygon points="178,35 185,23 192,35" fill="none" stroke="rgba(255,255,255,.72)" stroke-width="1.3" stroke-linejoin="round"/>
                    <text x="185" y="47" text-anchor="middle" fill="rgba(255,255,255,.5)" font-size="6.5" font-family="Plus Jakarta Sans,sans-serif">Arjuno</text>
                    <polygon points="72,113 80,100 88,113" fill="none" stroke="rgba(255,255,255,.72)" stroke-width="1.3" stroke-linejoin="round"/>
                    <text x="80" y="125" text-anchor="middle" fill="rgba(255,255,255,.5)" font-size="6.5" font-family="Plus Jakarta Sans,sans-serif">Kawi</text>
                </g>

                <!-- Coastline accent (south) -->
                <path class="coast-line" fill="none"
                    stroke="rgba(255,255,255,.28)" stroke-width="1.2" stroke-dasharray="8,5"
                    d="M 35,257 Q 62,310 95,321 Q 140,341 185,337 Q 230,333 272,294"/>

                <!-- Pulse ring for Kota Malang marker -->
                <circle class="dot-pulse" cx="192" cy="114" r="7"/>

                <!-- City / district dots -->
                <circle class="city-dot d1" cx="192" cy="114" r="5"/>  <!-- Kota Malang area -->
                <circle class="city-dot d2" cx="134" cy="91"  r="3.5"/><!-- Kota Batu area -->
                <circle class="city-dot d3" cx="282" cy="178" r="3.5"/><!-- Dampit / SE area -->
                <circle class="city-dot d4" cx="88"  cy="202" r="3.5"/><!-- Kepanjen / W area -->
                <circle class="city-dot d5" cx="188" cy="278" r="3.5"/><!-- Sumbermanjing / S area -->

                <!-- Labels -->
                <text class="map-lbl" x="192" y="200" text-anchor="middle"
                    fill="rgba(255,255,255,.82)" font-size="11"
                    font-family="Plus Jakarta Sans,sans-serif" font-weight="700" letter-spacing="2.5">KABUPATEN MALANG</text>
                <text class="map-lbl" x="192" y="215" text-anchor="middle"
                    fill="rgba(255,255,255,.48)" font-size="8.5"
                    font-family="Plus Jakarta Sans,sans-serif" font-weight="500" letter-spacing="1.5">JAWA TIMUR</text>
            </svg>
        </div>
    </div>
</section>

<!-- LAYANAN -->
<section class="section" id="layanan">
    <div class="section-header">
        <span class="section-eyebrow reveal">Layanan Kami</span>
        <h2 class="section-title reveal reveal-delay-1">Pelayanan Publik<br/>yang Transparan</h2>
        <p class="section-desc reveal reveal-delay-2">Kami menyediakan berbagai layanan administrasi dan teknis pendidikan untuk sekolah, guru, dan masyarakat di wilayah kami.</p>
    </div>
    <div class="layanan-grid">
        <div class="layanan-card reveal reveal-delay-1">
            <div class="layanan-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 12l2 2 4-4"/></svg>
            </div>
            <div class="layanan-name">Perizinan Sekolah</div>
            <div class="layanan-desc">Pengurusan izin operasional, izin mendirikan bangunan sekolah, dan sertifikasi lembaga pendidikan formal.</div>
        </div>
        <div class="layanan-card reveal reveal-delay-2">
            <div class="layanan-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/><path d="M15 11l2 2 4-4"/></svg>
            </div>
            <div class="layanan-name">Sertifikasi Guru</div>
            <div class="layanan-desc">Program peningkatan kompetensi dan sertifikasi profesi bagi tenaga pendidik SMA/SMK/SLB se-wilayah.</div>
        </div>
        <div class="layanan-card reveal reveal-delay-3">
            <div class="layanan-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <div class="layanan-name">Bantuan Siswa</div>
            <div class="layanan-desc">Penyaluran PIP, beasiswa prestasi, dan bantuan operasional untuk mendukung akses pendidikan merata.</div>
        </div>
        <div class="layanan-card reveal reveal-delay-1">
            <div class="layanan-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </div>
            <div class="layanan-name">Data Pendidikan</div>
            <div class="layanan-desc">Pengelolaan data pokok pendidikan (Dapodik), statistik sekolah, dan laporan kinerja lembaga.</div>
        </div>
        <div class="layanan-card reveal reveal-delay-2">
            <div class="layanan-icon">
                <svg viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h10"/><circle cx="18" cy="18" r="3"/><path d="M18 16v2l1 1"/></svg>
            </div>
            <div class="layanan-name">Kurikulum &amp; Mutu</div>
            <div class="layanan-desc">Pembinaan implementasi Kurikulum Merdeka, supervisi mutu pembelajaran, dan evaluasi standar nasional.</div>
        </div>
        <div class="layanan-card reveal reveal-delay-3">
            <div class="layanan-icon">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="layanan-name">Pengaduan &amp; Aspirasi</div>
            <div class="layanan-desc">Layanan pengaduan masyarakat, aspirasi komunitas pendidikan, dan tindak lanjut permasalahan lapangan.</div>
        </div>
    </div>
</section>

<!-- PRODUK -->
<section class="section section-alt" id="produk">
    <div class="section-header">
        <span class="section-eyebrow reveal">Produk</span>
        <h2 class="section-title reveal reveal-delay-1">Produk &amp;<br/>Karya Sekolah</h2>
        <p class="section-desc reveal reveal-delay-2">Produk terbaik dari sekolah-sekolah di wilayah Kabupaten Malang.</p>
    </div>
    @if($produk->count() > 0)
    <div class="produk-grid">
        @foreach($produk->take(8) as $item)
        <a href="{{ route('produk.allindex') }}" class="produk-card reveal reveal-delay-{{ ($loop->index % 4) + 1 }}">
            <div class="produk-thumb">
                @if($item->gambar)
                    <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama }}">
                @else
                    <div class="produk-thumb-placeholder">
                        <svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.2" width="28" height="28" style="opacity:0.3">
                            <rect x="6" y="2" width="24" height="36" rx="3"/>
                            <path d="M12 12h16M12 18h16M12 24h10"/>
                        </svg>
                        produk sekolah
                    </div>
                @endif
                <span class="produk-tag">{{ $item->kategori ?? 'Produk' }}</span>
            </div>
            <div class="produk-body">
                <div class="produk-name">{{ $item->nama }}</div>
                @if($item->nama_sekolah ?? false)
                <div class="produk-school">{{ $item->nama_sekolah }}</div>
                @endif
                <div class="produk-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
            </div>
        </a>
        @endforeach
    </div>
    @if($produk->count() > 8)
    <div style="text-align:center; margin-top:40px;">
        <a href="{{ route('produk.allindex') }}" class="btn-grad">Lihat Semua Produk &rarr;</a>
    </div>
    @endif
    @else
    <p style="text-align:center; color:var(--text-muted); padding:60px 0;">Belum ada produk yang tersedia.</p>
    @endif
</section>

<!-- PROSEDUR -->
<section class="section" id="prosedur">
    <div class="section-header">
        <span class="section-eyebrow reveal">Panduan</span>
        <h2 class="section-title reveal reveal-delay-1">Prosedur<br/>Pelayanan</h2>
        <p class="section-desc reveal reveal-delay-2">Panduan lengkap untuk mengakses layanan kami dengan mudah dan transparan.</p>
    </div>
    @if($kategoriProsedur->isNotEmpty())
    <div x-data="{ activeTab: {{ $kategoriProsedur->first()->id ?? 0 }} }">
        <div class="prosedur-tabs">
            @foreach($kategoriProsedur as $kat)
            <button
                class="prosedur-tab"
                :class="activeTab === {{ $kat->id }} ? 'prosedur-tab-active' : ''"
                @click="activeTab = {{ $kat->id }}">
                {{ $kat->nama }}
            </button>
            @endforeach
        </div>

        @foreach($kategoriProsedur as $kat)
        <div
            x-show="activeTab === {{ $kat->id }}"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-cloak>

            @if(str_contains(strtolower($kat->nama), 'dapodik'))
            <div class="dapodik-grid">
                @foreach(['edit_ptk' => 'Edit PTK', 'tambah_ptk' => 'Tambah PTK'] as $jenis => $label)
                @php $jadwal = $dapodikJadwals[$jenis] ?? null; @endphp
                <div class="dapodik-card">
                    <div class="dapodik-label">Jadwal Dapodik</div>
                    <div class="dapodik-title">{{ $label }}</div>
                    @if($jadwal && ($jadwal->tanggal_mulai || $jadwal->tanggal_selesai))
                        @if($jadwal->tanggal_mulai)
                        <div class="dapodik-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="var(--purple)" stroke-width="1.5" width="14" height="14" stroke-linecap="round" stroke-linejoin="round"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Mulai:</span>
                            <strong style="color:var(--text)">{{ $jadwal->tanggal_mulai->translatedFormat('d F Y') }}</strong>
                        </div>
                        @endif
                        @if($jadwal->tanggal_selesai)
                        <div class="dapodik-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="var(--purple)" stroke-width="1.5" width="14" height="14" stroke-linecap="round" stroke-linejoin="round"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Selesai:</span>
                            <strong style="color:var(--text)">{{ $jadwal->tanggal_selesai->translatedFormat('d F Y') }}</strong>
                        </div>
                        @endif
                        @if($jadwal->keterangan)
                        <p style="font-size:12px; color:var(--text-muted); font-style:italic; margin-top:8px;">{{ $jadwal->keterangan }}</p>
                        @endif
                    @else
                        <p style="font-size:13px; color:var(--text-muted); font-style:italic;">Jadwal belum tersedia.</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($kat->prosedursAktif->isNotEmpty())
            <div class="prosedur-grid">
                @foreach($kat->prosedursAktif as $i => $item)
                <a href="{{ route('prosedur.show', $item->id) }}" class="prosedur-card">
                    <div class="prosedur-num">{{ $i + 1 }}</div>
                    <div class="prosedur-title">{{ $item->judul }}</div>
                    <div class="prosedur-desc">{{ $item->deskripsi }}</div>
                    <div class="prosedur-link">Selengkapnya &rarr;</div>
                </a>
                @endforeach
            </div>
            @else
            <p style="text-align:center; color:var(--text-muted); padding:40px 0;">Belum ada prosedur dalam kategori ini.</p>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <p style="text-align:center; color:var(--text-muted); padding:40px 0;">Prosedur belum tersedia.</p>
    @endif
</section>

<!-- BERITA -->
<section class="section section-alt" id="berita">
    <div class="section-header">
        <span class="section-eyebrow reveal">Berita</span>
        <h2 class="section-title reveal reveal-delay-1">Informasi &amp;<br/>Pengumuman Terkini</h2>
        <p class="section-desc reveal reveal-delay-2">Ikuti perkembangan terbaru kegiatan, agenda, dan pengumuman resmi dari Cabang Dinas Pendidikan.</p>
    </div>
    @if($berita->count() > 0)
    @php $featured = $berita->first(); $others = $berita->skip(1)->take(4); @endphp
    <div class="berita-grid">
        <a href="{{ route('berita.show', $featured->id) }}" class="berita-featured reveal">
            <div class="berita-featured-img">
                @if($featured->thumbnail)
                    <img src="{{ asset('storage/'.$featured->thumbnail) }}" alt="{{ $featured->judul }}">
                @else
                    <svg viewBox="0 0 40 40" fill="none" stroke="white" stroke-width="1.2" width="36" height="36" style="opacity:0.25">
                        <rect x="4" y="4" width="32" height="32" rx="4"/><circle cx="14" cy="14" r="4"/><path d="M4 28l8-8 6 6 5-5 13 9"/>
                    </svg>
                @endif
            </div>
            <div class="berita-featured-body">
                <span class="berita-cat">Utama</span>
                <h3 class="berita-featured-title">{{ $featured->judul }}</h3>
                <p class="berita-featured-desc">{{ Str::limit(strip_tags($featured->konten), 180) }}</p>
                <div class="berita-meta">
                    <span>{{ \Carbon\Carbon::parse($featured->tanggal)->translatedFormat('d M Y') }}</span>
                    <span>&middot;</span>
                    <span>Admin Cabdin</span>
                </div>
                <div class="berita-read-more">Baca Selengkapnya &rarr;</div>
            </div>
        </a>
        <div class="berita-list">
            @foreach($others as $item)
            <a href="{{ route('berita.show', $item->id) }}" class="berita-item reveal reveal-delay-{{ $loop->iteration }}">
                <div class="berita-item-num">0{{ $loop->iteration }}</div>
                <div class="berita-item-content">
                    <div class="berita-item-title">{{ $item->judul }}</div>
                    <div class="berita-item-date">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @else
    <p style="text-align:center; color:var(--text-muted); padding:40px 0;">Belum ada berita yang tersedia.</p>
    @endif
</section>

<!-- STRUKTUR ORGANISASI -->
<section class="section" id="staff">
    <div class="section-header">
        <span class="section-eyebrow reveal">Organisasi</span>
        <h2 class="section-title reveal reveal-delay-1">Struktur<br/>Organisasi</h2>
        <p class="section-desc reveal reveal-delay-2">Susunan pejabat dan unit kerja Cabang Dinas Pendidikan Provinsi Jawa Timur Wilayah Kabupaten Malang.</p>
    </div>

    <div class="org-wrap reveal reveal-delay-1">
        <div class="org-level">
            <div class="org-node deputy">
                <div class="org-node-avatar">DA</div>
                <div class="org-node-name">Dwi Anggraeni, S.Pd. M.Pd.</div>
                <div class="org-node-role">Kepala Cabang Dinas Pendidikan</div>
            </div>
        </div>
        <div class="org-connector-line"></div>
        <div style="display:flex; justify-content:center;">
            <div style="display:flex; flex-wrap:wrap; justify-content:center;">
                <div style="display:flex; flex-direction:column; align-items:center; padding:0 8px; border-top:2px solid var(--border);">
                    <div style="width:2px; height:22px; background:var(--border);"></div>
                    <div class="org-node">
                        <div class="org-node-avatar">RK</div>
                        <div class="org-node-name">Rizal Kurniawan, S.Pd.</div>
                        <div class="org-node-role">Kepala Sub Bag TU</div>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; padding:0 8px; border-top:2px solid var(--border);">
                    <div style="width:2px; height:22px; background:var(--border);"></div>
                    <div class="org-node">
                        <div class="org-node-avatar">HG</div>
                        <div class="org-node-name">Hakso Gatut P., S.H.</div>
                        <div class="org-node-role">Kasi SMA / PK / PLK</div>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; padding:0 8px; border-top:2px solid var(--border);">
                    <div style="width:2px; height:22px; background:var(--border);"></div>
                    <div class="org-node">
                        <div class="org-node-avatar">EH</div>
                        <div class="org-node-name">Evi Murti Hidayati</div>
                        <div class="org-node-role">Kasi SMK</div>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; padding:0 8px; border-top:2px solid var(--border);">
                    <div style="width:2px; height:22px; background:var(--border);"></div>
                    <div class="org-node">
                        <div class="org-node-avatar">PW</div>
                        <div class="org-node-name">Pengawas Sekolah</div>
                        <div class="org-node-role">Ahli Utama / Madya / Muda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ activeTab: 'tu' }">
        <div class="staff-tabs">
            <button class="staff-tab" :class="activeTab === 'tu' ? 'staff-tab-active' : ''" @click="activeTab = 'tu'">Sub Bag Tata Usaha</button>
            <button class="staff-tab" :class="activeTab === 'sma' ? 'staff-tab-active' : ''" @click="activeTab = 'sma'">Seksi SMA / PK / PLK</button>
            <button class="staff-tab" :class="activeTab === 'smk' ? 'staff-tab-active' : ''" @click="activeTab = 'smk'">Seksi SMK</button>
            <button class="staff-tab" :class="activeTab === 'pengawas' ? 'staff-tab-active' : ''" @click="activeTab = 'pengawas'">Pengawas</button>
        </div>

        <div x-show="activeTab === 'tu'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
            <div class="staff-grid">
                @foreach([
                    ['AM','Ahmad Mujib','19790721 201408 1 002','Pengadministrasi Perkantoran'],
                    ['MA','Muhammad Aditya Darma Saputra, ST.','20020110 202504 1 001','Penata Kelola Sistem TI'],
                    ['HS','Heri Subagyo, S.Pd.','19880903 202521 1 101','Penata Layanan Operasional'],
                    ['AS','Adib Siswono, A.Md.','19770630 202521 1 041','Pengelola Layanan Operasional'],
                    ['RS','Rois Safutro, SE.','19870707 202521 1 232','Penata Pelayanan Operasional'],
                    ['RJ','Rista Julia Muchroma','—','Pengadministrasi Umum'],
                    ['RN','Rully Yulian Nursobah, S.Kom.','19840728 201408 1 002','Bendahara Pengeluaran Pembantu'],
                    ['Mu','Mudrikah, S.Pd.','19770309 201408 2 001','Pengadministrasi Perkantoran'],
                    ['AO','Akhmad Oddi Awaludin, SE.','19910407 202521 1 133','Penata Layanan Operasional'],
                    ['ST','Septian Trijoko Siswandaru, S.M.','19810926 202521 1 078','Penata Layanan Operasional'],
                    ['FA','Fahrurrino Sofian Akbar A.','19911125 202521 1 130','Operator Layanan Operasional'],
                ] as $s)
                <div class="staff-card">
                    <div class="staff-avatar">{{ $s[0] }}</div>
                    <div>
                        <div class="staff-role">{{ $s[3] }}</div>
                        <div class="staff-name">{{ $s[1] }}</div>
                        <div class="staff-nip">NIP. {{ $s[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="activeTab === 'sma'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
            <div class="staff-grid" style="max-width:600px;">
                @foreach([
                    ['HK','Haryono Kurniawan','19690820 200801 1 014','Pengadministrasi Perkantoran'],
                    ['LM','Lutvian Marta, A.Md.','19920124 202521 1 004','Pengelola Layanan Operasional'],
                ] as $s)
                <div class="staff-card">
                    <div class="staff-avatar" style="background:#3B6FE8;">{{ $s[0] }}</div>
                    <div>
                        <div class="staff-role" style="color:#3B6FE8;">{{ $s[3] }}</div>
                        <div class="staff-name">{{ $s[1] }}</div>
                        <div class="staff-nip">NIP. {{ $s[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="activeTab === 'smk'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
            <div class="staff-grid" style="max-width:600px;">
                @foreach([
                    ['PN','Prasetyo Nugroho, S.Kom.','19731018 201408 1 001','Pengadministrasi Perkantoran'],
                    ['YP','Yuswinda Eka Puspitasari, SE.','19911211 202521 2 109','Penata Layanan Operasional'],
                ] as $s)
                <div class="staff-card">
                    <div class="staff-avatar" style="background:#6B3FE0;">{{ $s[0] }}</div>
                    <div>
                        <div class="staff-role" style="color:#6B3FE0;">{{ $s[3] }}</div>
                        <div class="staff-name">{{ $s[1] }}</div>
                        <div class="staff-nip">NIP. {{ $s[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="activeTab === 'pengawas'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
            <div class="staff-grid" style="max-width:600px;">
                @foreach(['Pengawas Sekolah Ahli Utama', 'Pengawas Sekolah Ahli Madya', 'Pengawas Sekolah Ahli Muda'] as $i => $label)
                <div class="staff-card">
                    <div class="staff-avatar" style="background:#7B2FF7; font-size:16px; font-weight:800;">{{ $i + 1 }}</div>
                    <div>
                        <div class="staff-name">{{ $label }}</div>
                        <div class="staff-nip">Jenjang Fungsional</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

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
            <div class="footer-col-title">Layanan</div>
            <div class="footer-links">
                <a href="#layanan">Perizinan Sekolah</a>
                <a href="#layanan">Sertifikasi Guru</a>
                <a href="#layanan">Bantuan Siswa</a>
                <a href="#layanan">Data Pendidikan</a>
                <a href="#layanan">Pengaduan</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Navigasi</div>
            <div class="footer-links">
                <a href="#hero">Beranda</a>
                <a href="#produk">Produk Sekolah</a>
                <a href="#prosedur">Prosedur</a>
                <a href="#berita">Berita</a>
                <a href="#staff">Organisasi</a>
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
        <div class="footer-copy">&copy; 2026 E-Cabdin &mdash; Cabang Dinas Pendidikan Kab. Malang. All rights reserved.</div>
    </div>
</footer>

<script>
    // Navbar scroll shadow
    const nav = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 20);
    });

    // Scroll reveal
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.length <= 1) return;
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
</script>
</body>
</html>
