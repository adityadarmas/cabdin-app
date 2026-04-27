<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Produk - E-Cabdin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- ===== HEADER ===== --}}
<header class="bg-gradient-to-r from-sky-600 to-blue-700 text-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center font-bold text-xl">E</div>
            <span class="text-xl font-bold tracking-wide">E-CABDIN</span>
        </div>
        <a href="{{ url('/landing') }}" class="text-sm text-white/80 hover:text-white transition">&#8592; Beranda</a>
    </div>
</header>

{{-- ===== HERO ===== --}}
<section class="bg-gradient-to-r from-sky-600 to-blue-700 text-white pb-10">
    <div class="max-w-7xl mx-auto px-6 pt-10 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Produk & Layanan</h1>
        <p class="text-sky-100 text-sm md:text-base mb-8">
            Temukan produk unggulan dari berbagai sekolah
        </p>

        {{-- Stats --}}
        <div class="flex justify-center gap-8 mb-8">
            <div class="text-center">
                <p class="text-3xl font-bold">{{ $totalSekolah }}</p>
                <p class="text-xs text-sky-200 uppercase tracking-wide">Sekolah</p>
            </div>
            <div class="w-px bg-white/20"></div>
            <div class="text-center">
                <p class="text-3xl font-bold">{{ $totalProduk }}</p>
                <p class="text-xs text-sky-200 uppercase tracking-wide">Produk</p>
            </div>
        </div>

        {{-- Search --}}
        <div class="max-w-xl mx-auto">
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                <input id="searchInput" type="text" placeholder="Cari nama produk atau sekolah..."
                       class="w-full pl-10 pr-4 py-3 rounded-full text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-300 shadow">
            </div>
        </div>
    </div>
</section>

{{-- ===== FILTER KATEGORI ===== --}}
<div class="sticky top-0 z-10 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex gap-2 overflow-x-auto scrollbar-hide">
        @php
            $kategoriList = [
                'semua'     => ['label' => 'Semua',     'icon' => '🏪'],
                'jasa'      => ['label' => 'Jasa',      'icon' => '🛠️'],
                'makanan'   => ['label' => 'Makanan',   'icon' => '🍱'],
                'minuman'   => ['label' => 'Minuman',   'icon' => '🥤'],
                'kerajinan' => ['label' => 'Kerajinan', 'icon' => '🎨'],
                'pertanian' => ['label' => 'Pertanian', 'icon' => '🌱'],
                'teknologi' => ['label' => 'Teknologi', 'icon' => '💻'],
                'lainnya'   => ['label' => 'Lainnya',   'icon' => '📦'],
            ];
            $aktif = $kategori ?? 'semua';
        @endphp
        @foreach ($kategoriList as $key => $val)
            <a href="{{ route('produk.allindex', $key !== 'semua' ? ['kategori' => $key] : []) }}"
               class="flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition
                      {{ $aktif === $key
                          ? 'bg-blue-600 text-white shadow'
                          : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                <span>{{ $val['icon'] }}</span>
                <span>{{ $val['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

{{-- ===== KONTEN ===== --}}
<main class="max-w-7xl mx-auto px-6 py-8" id="produkContainer">

    @forelse ($sekolahList as $namaSekolah => $produkSekolah)
        <div class="sekolah-group mb-10">

            {{-- Nama Sekolah --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm">
                    {{ strtoupper(substr($namaSekolah, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-bold text-gray-800 text-base sekolah-nama">{{ $namaSekolah }}</h2>
                    <p class="text-xs text-gray-400">{{ $produkSekolah->count() }} produk</p>
                </div>
                <div class="flex-1 h-px bg-gray-200 ml-2"></div>
            </div>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($produkSekolah as $item)
                <div class="produk-card bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100"
                     data-nama="{{ strtolower($item->nama) }}"
                     data-sekolah="{{ strtolower($namaSekolah) }}">

                    {{-- Gambar --}}
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}"
                             alt="{{ $item->nama }}"
                             class="h-36 w-full object-cover">
                    @else
                        <div class="h-36 w-full bg-gradient-to-br from-sky-100 to-blue-100 flex items-center justify-center text-3xl">
                            {{ $kategoriList[$item->kategori]['icon'] ?? '📦' }}
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="p-3">
                        {{-- Badge kategori --}}
                        <span class="text-xs px-2 py-0.5 rounded-full bg-sky-100 text-sky-600 font-medium">
                            {{ $kategoriList[$item->kategori]['icon'] ?? '' }} {{ ucfirst($item->kategori) }}
                        </span>

                        <h3 class="font-semibold text-gray-800 text-sm mt-1.5 line-clamp-2 leading-snug">
                            {{ $item->nama }}
                        </h3>

                        <p class="text-blue-600 font-bold text-sm mt-1">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </p>

                        {{-- Nama Sekolah --}}
                        <p class="text-xs text-gray-400 mt-1 truncate">
                            🏫 {{ $item->operator?->nama_sekolah ?? 'Umum' }}
                        </p>

                        {{-- Tombol aksi --}}
                        <div class="mt-2 flex gap-1.5">
                            @if ($item->operator?->no_wa)
                                @php
                                    $noWa = preg_replace('/[^0-9]/', '', $item->operator->no_wa);
                                    $noWa = preg_replace('/^0/', '62', $noWa);
                                @endphp
                                <a href="https://wa.me/{{ $noWa }}" target="_blank"
                                   class="flex-1 text-center text-xs bg-green-500 hover:bg-green-600 text-white py-1.5 rounded-lg transition flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WA
                                </a>
                            @endif
                            @if ($item->link_produk)
                                <a href="{{ $item->link_produk }}" target="_blank"
                                   class="flex-1 text-center text-xs bg-blue-600 hover:bg-blue-700 text-white py-1.5 rounded-lg transition">
                                    Detail
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">🏪</p>
            <p class="text-lg font-medium">Belum ada produk tersedia</p>
            <p class="text-sm">untuk kategori ini</p>
        </div>
    @endforelse

    {{-- Tidak ditemukan saat search --}}
    <div id="emptySearch" class="hidden text-center py-20 text-gray-400">
        <p class="text-5xl mb-4">🔍</p>
        <p class="text-lg font-medium">Produk tidak ditemukan</p>
        <p class="text-sm">Coba kata kunci lain</p>
    </div>

</main>

{{-- ===== FOOTER ===== --}}
<footer class="bg-gray-800 text-gray-400 text-center text-xs py-6 mt-10">
    <p>&copy; {{ date('Y') }} E-Cabdin &mdash; Platform Produk Sekolah</p>
</footer>

<script>
    // Search filter client-side
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let totalVisible = 0;

        document.querySelectorAll('.sekolah-group').forEach(function (group) {
            const sekolahNama = group.querySelector('.sekolah-nama')?.textContent.toLowerCase() ?? '';
            let groupVisible = 0;

            group.querySelectorAll('.produk-card').forEach(function (card) {
                const nama    = card.dataset.nama ?? '';
                const sekolah = card.dataset.sekolah ?? '';
                const match   = nama.includes(q) || sekolah.includes(q);
                card.style.display = match ? '' : 'none';
                if (match) groupVisible++;
            });

            group.style.display = groupVisible > 0 ? '' : 'none';
            totalVisible += groupVisible;
        });

        document.getElementById('emptySearch').style.display = totalVisible === 0 ? '' : 'none';
    });
</script>

</body>
</html>
