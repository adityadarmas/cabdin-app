<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Surat - {{ $surat->nomor_surat }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-pagination-bullet-active {
            background: #0ea5e9 !important;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #0ea5e9 !important;
        }
    </style>
</head>

<body class="bg-slate-50">

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-sky-100 rounded-full mb-4">
                    <span class="text-3xl">📨</span>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">
                    Tracking Surat
                </h1>
                <p class="text-slate-600">
                    Lacak status dan progress surat Anda
                </p>
            </div>

            {{-- Tombol Refresh --}}
            <div class="text-center mb-4">
                <button onclick="location.reload()"
                    class="px-6 py-3 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition font-medium shadow-md">
                    🔄 Refresh Status
                </button>
            </div>

            {{-- STATUS CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden mb-6">

                {{-- Status Badge --}}
                @php
                    $status = $surat->status_for_tamu;
                    $colorClasses = [
                        'blue' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'green' => 'bg-green-100 text-green-800 border-green-200',
                    ];
                @endphp

                <div class="p-6 border-b border-slate-200 {{ $colorClasses[$status['color']] ?? 'bg-slate-100' }}">
                    <div class="flex items-center justify-center gap-3">
                        <span class="text-4xl">{{ $status['icon'] }}</span>
                        <div class="text-center">
                            <h2 class="text-2xl font-bold">{{ $status['label'] }}</h2>
                            <p class="text-sm mt-1">{{ $status['description'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Detail Surat --}}
                <div class="p-6">
                    <h3 class="font-semibold text-slate-800 mb-4 text-lg">
                        📋 Informasi Surat
                    </h3>

                    <div class="space-y-3">
                        <div class="flex">
                            <span class="w-1/3 text-slate-600 font-medium">Nomor Surat:</span>
                            <span class="w-2/3 text-slate-800">{{ $surat->nomor_surat }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-1/3 text-slate-600 font-medium">Perihal:</span>
                            <span class="w-2/3 text-slate-800">{{ $surat->perihal }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-1/3 text-slate-600 font-medium">Asal:</span>
                            <span class="w-2/3 text-slate-800">{{ $surat->asal }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-1/3 text-slate-600 font-medium">Tanggal Diterima:</span>
                            <span class="w-2/3 text-slate-800">{{ $surat->tgl_diterima->format('d F Y') }}</span>
                        </div>
                        @if ($surat->tgl_kegiatan)
                            <div class="flex">
                                <span class="w-1/3 text-slate-600 font-medium">Tanggal Kegiatan:</span>
                                <span class="w-2/3 text-slate-800">{{ $surat->tgl_kegiatan->format('d F Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Timeline Progress --}}
                @if ($surat->is_disposisi && $surat->penerima && $surat->penerima->count() > 0)
                    {{-- DISPOSISI: tampilkan per staff --}}
                    <div class="p-6 bg-slate-50 border-t border-slate-200">
                        <h3 class="font-semibold text-slate-800 mb-4 text-lg">
                            ⏱️ Progress Penanganan
                        </h3>

                        <div class="space-y-4">
                            @foreach ($surat->penerima as $penerima)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 mt-1">
                                        @if ($penerima->pivot->status === 'selesai')
                                            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm">✓</div>
                                        @elseif($penerima->pivot->status === 'dibaca')
                                            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm">⋯</div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-slate-300 text-white flex items-center justify-center text-sm">○</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800">Tim Penanganan</p>
                                        <p class="text-sm text-slate-600">
                                            @if ($penerima->pivot->status === 'selesai')
                                                Selesai diproses
                                                @if ($penerima->pivot->tanggal_selesai)
                                                    — {{ \Carbon\Carbon::parse($penerima->pivot->tanggal_selesai)->translatedFormat('d F Y, H:i') }}
                                                @endif
                                            @elseif($penerima->pivot->status === 'dibaca')
                                                Sedang diproses
                                                @if ($penerima->pivot->tanggal_dibaca)
                                                    — {{ \Carbon\Carbon::parse($penerima->pivot->tanggal_dibaca)->translatedFormat('d F Y, H:i') }}
                                                @endif
                                            @else
                                                Menunggu penanganan
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(!$surat->is_disposisi)
                    {{-- NON-DISPOSISI: timeline status flow --}}
                    @php
                        $steps = [
                            ['key' => 'diterima',     'label' => 'Surat Diterima',         'date' => $surat->tgl_diterima,     'icon' => '📨'],
                            ['key' => 'dikirim',      'label' => 'Dikirim ke Pimpinan',    'date' => $surat->tgl_dikirim,      'icon' => '📤'],
                            ['key' => 'disetujui',    'label' => 'Disetujui Pimpinan',     'date' => $surat->tgl_disetujui,    'icon' => '✅'],
                            ['key' => 'siap_diambil', 'label' => 'Selesai / Siap Diambil', 'date' => $surat->tgl_siap_diambil, 'icon' => '🎉'],
                        ];
                        $statusOrder = ['diterima' => 0, 'dikirim' => 1, 'disetujui' => 2, 'siap_diambil' => 3];
                        $currentOrder = $statusOrder[$surat->status] ?? 0;
                    @endphp
                    <div class="p-6 bg-slate-50 border-t border-slate-200">
                        <h3 class="font-semibold text-slate-800 mb-5 text-lg">⏱️ Riwayat Status</h3>
                        <ol class="relative border-l-2 border-slate-200 ml-3 space-y-6">
                            @foreach($steps as $step)
                                @php
                                    $stepOrder = $statusOrder[$step['key']] ?? 0;
                                    $done   = $stepOrder < $currentOrder || $surat->status === $step['key'];
                                    $active = $surat->status === $step['key'];
                                @endphp
                                <li class="ml-6">
                                    <span class="absolute -left-3.5 flex items-center justify-center w-7 h-7 rounded-full
                                        {{ $done ? ($active ? 'bg-sky-500 ring-2 ring-sky-200' : 'bg-green-500') : 'bg-slate-300' }}
                                        text-white text-xs font-bold shadow">
                                        {{ $done && !$active ? '✓' : ($active ? '●' : '○') }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">{{ $step['icon'] }}</span>
                                        <p class="font-semibold text-sm {{ $done ? 'text-slate-800' : 'text-slate-400' }}">
                                            {{ $step['label'] }}
                                        </p>
                                        @if($active)
                                            <span class="text-xs bg-sky-100 text-sky-700 px-2 py-0.5 rounded-full font-medium">Sekarang</span>
                                        @endif
                                    </div>
                                    @if($step['date'])
                                        <p class="text-xs text-slate-500 mt-0.5 ml-6">
                                            {{ \Carbon\Carbon::parse($step['date'])->translatedFormat('d F Y') }}
                                        </p>
                                    @elseif(!$done)
                                        <p class="text-xs text-slate-400 mt-0.5 ml-6 italic">Menunggu...</p>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                {{-- Footer Info --}}
                <div class="p-4 bg-slate-100 text-center text-xs text-slate-600">
                    <p>Simpan link ini untuk memantau status surat Anda kapan saja.</p>
                </div>

            </div>

            {{-- CAROUSEL PRODUK --}}
            @if ($produk && $produk->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden mb-6">
                    <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-sky-50 to-blue-50">
                        <h3 class="font-bold text-slate-800 text-xl flex items-center gap-2">
                            <span class="text-2xl">🛍️</span>
                            Produk Kami
                        </h3>
                        <p class="text-sm text-slate-600 mt-1">Jelajahi produk dan layanan terbaik kami</p>
                    </div>

                    <div class="p-6">
                        <div class="swiper produkSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($produk as $item)
                                    <div class="swiper-slide">
                                        <div
                                            class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition h-full">
                                            @if ($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                                    alt="{{ $item->nama }}" class="w-full h-48 object-cover"
                                                    
                                                    >
                                            @else
                                                <div
                                                    class="w-full h-48 bg-gradient-to-br from-sky-100 to-blue-100 flex items-center justify-center">
                                                    <span class="text-5xl">📦</span>
                                                </div>
                                            @endif

                                            <div class="p-4">
                                                <h4 class="font-semibold text-slate-800 mb-2 text-left line-clamp-2">
                                                    {{ $item->nama }}
                                                </h4>
                                                <p class="text-sm text-slate-600 text-left line-clamp-3 mb-3">
                                                    {{ $item->deskripsi }}
                                                </p>
                                                @if ($item->harga)
                                                    <p class="text-lg font-bold text-sky-600 text-left">
                                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Navigation --}}
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            {{-- Pagination --}}
                            <div class="swiper-pagination mt-4"></div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- CAROUSEL BERITA --}}
            @if ($berita && $berita->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden mb-6">
                    <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="font-bold text-slate-800 text-xl flex items-center gap-2">
                            <span class="text-2xl">📰</span>
                            Berita & Informasi
                        </h3>
                        <p class="text-sm text-slate-600 mt-1">Update terkini dari kami untuk Anda</p>
                    </div>

                    <div class="p-6">
                        <div class="swiper beritaSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($berita as $item)
                                    <div class="swiper-slide">
                                        <div
                                            class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition h-full" onclick="window.location='{{ route('berita.show', $item->id) }}'">
                                            @if ($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                                    alt="{{ $item->judul }}" class="w-full h-48 object-cover"
                                                    >
                                            @else
                                                <div
                                                    class="w-full h-48 bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                    <span class="text-5xl">📄</span>
                                                </div>
                                            @endif

                                            <div class="p-4">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span
                                                        class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                                        {{ $item->kategori ?? 'Berita' }}
                                                    </span>
                                                    <span class="text-xs text-slate-500">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                </div>

                                                <h4 class="font-semibold text-slate-800 mb-2 text-left line-clamp-2">
                                                    {{ $item->judul }}
                                                </h4>
                                                <p class="text-sm text-slate-600 text-left line-clamp-3">
                                                    {{ strip_tags($item->konten) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Navigation --}}
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            {{-- Pagination --}}
                            <div class="swiper-pagination mt-4"></div>
                        </div>
                    </div>
                </div>
            @endif



        </div>
    </div>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- Initialize Swipers --}}
    <script>
        // Produk Swiper
        const produkSwiper = new Swiper('.produkSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.produkSwiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.produkSwiper .swiper-button-next',
                prevEl: '.produkSwiper .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });

        // Berita Swiper
        const beritaSwiper = new Swiper('.beritaSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.beritaSwiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.beritaSwiper .swiper-button-next',
                prevEl: '.beritaSwiper .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });
    </script>

    {{-- Line clamp utility --}}
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

</body>

</html>
