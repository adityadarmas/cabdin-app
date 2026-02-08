<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Cabdin - Cabang Dinas Pendidikan Wilayah Kabupaten Malang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gradient-to-br from-sky-50 via-blue-50 to-sky-100 text-slate-800 scroll-smooth">

<!-- HEADER -->
<header id="main-header" class="sticky top-0 z-50 bg-white/80 backdrop-blur-md transition-all duration-300 border-b border-sky-100">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">E</span>
            </div>
            <span class="text-xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">E-CABDIN</span>
        </div>
        <nav class="hidden md:flex items-center gap-8">
            <a href="#profil" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                Profil
            </a>
            <a href="#produk" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                Produk
            </a>
            <a href="#prosedur" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                Prosedur
            </a>
            <a href="#berita" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                Berita
            </a>
            <a href="#staff" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                Staff
            </a>
        </nav>
        <a href="{{ route('login') }}" class="bg-gradient-to-r from-sky-500 to-blue-600 text-white px-6 py-2 rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300 text-sm font-medium">
            Masuk
        </a>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-12 space-y-20">

    <!-- HERO SECTION / PROFIL INSTANSI -->
    <section id="profil" class="scroll-mt-24 min-h-[70vh] flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-6">
            <div class="inline-block px-4 py-2 bg-sky-100 text-sky-700 rounded-full text-sm font-medium">
                Pemerintah Provinsi Jawa Timur
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                Cabang Dinas Pendidikan Provinsi Jawa Timur
            </h1>
            <h2 class="text-4xl md:text-6xl font-extrabold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent leading-tight">
                Wilayah Kabupaten Malang
            </h2>
            <p class="text-lg text-slate-600 max-w-xl leading-relaxed">
                Kami melayani administrasi pendidikan menengah atas di wilayah Kabupaten Malang secara digital dan terintegrasi untuk kemajuan pendidikan Indonesia.
            </p>
            <div class="flex gap-4 pt-4">
                <a href="#produk" class="bg-gradient-to-r from-sky-500 to-blue-600 text-white px-8 py-3 rounded-full hover:shadow-xl hover:scale-105 transition-all duration-300 font-medium">
                    Jelajahi Produk
                </a>
                <a href="#staff" class="bg-white text-sky-600 border-2 border-sky-200 px-8 py-3 rounded-full hover:bg-sky-50 transition-all duration-300 font-medium">
                    Lihat Tim Kami
                </a>
            </div>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-400 to-blue-600 rounded-3xl blur-3xl opacity-20"></div>
                <img src="/images/jatim.png"
                     alt="Logo Provinsi Jawa Timur"
                     class="relative h-80 w-auto drop-shadow-2xl">
            </div>
        </div>
    </section>

<!-- PRODUK SECTION -->
<section id="produk" class="scroll-mt-24">
    <div class="text-center mb-12">
        <h3 class="text-4xl font-bold text-slate-900 mb-3">
            Produk Unggulan
        </h3>
        <p class="text-lg text-slate-600">
            Hasil karya terbaik dari sekolah-sekolah di Kabupaten Malang
        </p>
    </div>

    <div class="space-y-8">

        @foreach ($produk->take(3) as $index => $item)
        <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-sky-100">

            <div class="flex flex-col 
                {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} 
                items-center gap-8">

                <!-- Gambar -->
                <div class="w-48 h-48 bg-gradient-to-br from-sky-100 to-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}"
                             alt="{{ $item->nama }}"
                             class="w-40 h-40 object-contain">
                    @else
                        <img src="/images/default-product.png" class="w-40 h-40 object-contain">
                    @endif
                </div>

                <!-- Konten -->
                <div class="flex-1 space-y-3 {{ $index % 2 == 0 ? '' : 'text-left md:text-right' }}">
                    
                    <!-- Label Sekolah (dummy dulu) -->
                    <div class="inline-block px-3 py-1 bg-sky-100 text-sky-700 rounded-full text-xs font-semibold">
                        Produk Sekolah
                    </div>

                    <!-- Nama Produk -->
                    <h4 class="text-3xl md:text-4xl font-bold text-slate-900">
                        {{ $item->nama }}
                    </h4>

                    <!-- Deskripsi -->
                    <p class="text-slate-600">
                        {{ $item->deskripsi }}
                    </p>

                    <!-- Harga + Button -->
                    <div class="flex items-center gap-4 pt-2 
                        {{ $index % 2 == 0 ? '' : 'justify-start md:justify-end' }}">

                        @if($index % 2 == 0)
                            <button class="bg-gradient-to-r from-sky-500 to-blue-600 text-white px-6 py-2.5 rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium">
                                Lihat Detail
                            </button>
                        @endif

                        <span class="text-2xl font-bold text-sky-600">
                            Rp {{ number_format($item->harga,0,',','.') }}
                        </span>

                        @if($index % 2 == 1)
                            <button class="bg-gradient-to-r from-blue-500 to-sky-600 text-white px-6 py-2.5 rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium">
                                Lihat Detail
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @endforeach

        @if($produk->count() == 0)
        <div class="text-center text-gray-500 bg-white p-8 rounded-xl shadow">
            Belum ada produk yang tersedia.
        </div>
        @endif

        <a href="{{ route('produk.allindex') }}"
        class="bg-gradient-to-r from-sky-500 to-blue-600 text-white px-6 py-2.5 rounded-full
            hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium">
        Lihat Semua Produk
        </a>

    </div>
        

    <section id="prosedur" class="scroll-mt-24">
        <div class="text-center mb-12">
            <h3 class="text-4xl font-bold text-slate-900 mb-3">
                Prosedur Pelayanan
            </h3>
            <p class="text-lg text-slate-600">
                Panduan lengkap untuk mengakses layanan kami
            </p>
        </div>

        <div
            x-data="{
                index: 0,
                total: {{ $prosedur->count() }},
                timer: null,

                start() {
                    this.stop()
                    this.timer = setInterval(() => {
                        this.next()
                    }, 4000)
                },

                stop() {
                    if (this.timer) {
                        clearInterval(this.timer)
                        this.timer = null
                    }
                },

                next() {
                    this.index = this.index < this.total - 1 ? this.index + 1 : 0
                },

                prev() {
                    this.index = this.index > 0 ? this.index - 1 : this.total - 1
                }
            }"
            x-init="start()"
            @mouseenter="stop()"
            @mouseleave="start()"
            class="relative max-w-4xl mx-auto"
        >
            <!-- SLIDER -->
            <div class="overflow-hidden">
                <div 
                    class="flex transition-transform duration-500"
                    :style="`transform: translateX(-${index * 100}%)`"
                >
                    @foreach($prosedur as $i => $item)
                    <div class="min-w-full md:min-w-1/3 px-3">
                        <a href="{{ route('prosedur.show', $item->id) }}"
                        class="block bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl
                                transition-all duration-300 border border-sky-100 hover:border-sky-300">

                            <div class="w-12 h-12 bg-gradient-to-br from-sky-400 to-blue-600
                                        rounded-xl flex items-center justify-center mb-4">
                                <span class="text-white font-bold text-xl">
                                    {{ $i + 1 }}
                                </span>
                            </div>

                            <h4 class="text-xl font-bold text-slate-900 mb-2">
                                {{ $item->judul }}
                            </h4>

                            <p class="text-slate-600 line-clamp-3">
                                {{ $item->deskripsi }}
                            </p>

                            <span class="inline-block mt-4 text-sky-600 font-semibold">
                                Baca Selengkapnya →
                            </span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- NAVIGATION -->
            <div class="flex justify-center gap-4 mt-6">
                <button
                    @click="index = Math.max(index - 1, 0)"
                    class="px-4 py-2 bg-sky-100 rounded-full hover:bg-sky-200">
                    ‹
                </button>

                <button
                    @click="index = Math.min(index + 1, total - 1)"
                    class="px-4 py-2 bg-sky-100 rounded-full hover:bg-sky-200">
                    ›
                </button>
            </div>
        </div>
    </section>

    {{-- Berita section --}}
    <section id="berita" class="scroll-mt-24">
        <div class="text-center mb-12">
            <h3 class="text-4xl font-bold text-slate-900 mb-3">
                Berita Terbaru
            </h3>
            <p class="text-lg text-slate-600">
                Informasi dan update terkini dari Cabang Dinas Pendidikan
            </p>
        </div>

        <div
            x-data="{
                index: 0,
                total: {{ $berita->count() }},
                timer: null,

                start() {
                    this.stop()
                    this.timer = setInterval(() => {
                        this.next()
                    }, 2000)
                },

                stop() {
                    if (this.timer) {
                        clearInterval(this.timer)
                        this.timer = null
                    }
                },

                next() {
                    this.index = this.index < this.total - 1 ? this.index + 1 : 0
                },

                prev() {
                    this.index = this.index > 0 ? this.index - 1 : this.total - 1
                }
            }"
            x-init="start()"
            @mouseover="stop()"
            @mouseout="start()"
            class="relative max-w-4xl mx-auto cursor-pointer"
        >

            <!-- SLIDER -->
            <div class="overflow-hidden">
                <div
                    class="flex transition-transform duration-700 ease-in-out"
                    :style="`transform: translateX(-${index * 100}%)`"
                >
                    @foreach($berita as $item)
                    <div class="min-w-full px-4">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-sky-100">

                            <!-- Thumbnail -->
                            <div class="h-48 bg-sky-100">
                                @if($item->thumbnail)
                                    <img src="{{ asset('storage/'.$item->thumbnail) }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6 space-y-3">
                                <span class="text-sm text-sky-600 font-semibold">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </span>

                                <h4 class="text-2xl font-bold text-slate-900">
                                    {{ $item->judul }}
                                </h4>

                                <p class="text-slate-600 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->konten), 150) }}
                                </p>

                                <a href="{{ route('berita.show', $item->id) }}"
                                class="inline-flex items-center text-sky-600 font-semibold hover:text-sky-700">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- NAVIGATION -->
            <div class="flex justify-center items-center gap-6 mt-8">

                <button
                    @click="prev(); start()"
                    class="w-10 h-10 flex items-center justify-center
                        bg-sky-100 rounded-full hover:bg-sky-200 transition">
                    ‹
                </button>

                <!-- DOT INDICATOR -->
                <div class="flex gap-2">
                    @foreach($berita as $i => $item)
                    <button
                        @click="index={{ $i }}; start()"
                        class="w-3 h-3 rounded-full transition"
                        :class="index === {{ $i }} ? 'bg-sky-600 scale-110' : 'bg-sky-300'">
                    </button>
                    @endforeach
                </div>

                <button
                    @click="next(); start()"
                    class="w-10 h-10 flex items-center justify-center
                        bg-sky-100 rounded-full hover:bg-sky-200 transition">
                    ›
                </button>
            </div>

        </div>
    </section>





    <!-- STAFF SECTION -->
    <section id="staff" class="scroll-mt-24">
        <div class="bg-gradient-to-br from-sky-500 to-blue-600 rounded-3xl p-8 md:p-12 text-white shadow-2xl">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-bold mb-2">
                    Staff Cabang Dinas Pendidikan
                </h3>
                <p class="text-sky-100 text-lg">
                    Wilayah Kabupaten Malang
                </p>
            </div>

            <!-- KEPALA CABANG -->
            <div class="flex justify-center mb-10">
                <div class="bg-white text-slate-800 rounded-2xl p-6 text-center w-64 shadow-xl">
                    <div class="h-20 w-20 mx-auto bg-gradient-to-br from-sky-200 to-blue-300 rounded-full mb-3 flex items-center justify-center">
                        <span class="text-2xl font-bold text-sky-700">DA</span>
                    </div>
                    <p class="text-base font-bold text-slate-900">Kepala Cabang Dinas</p>
                    <p class="text-sm text-slate-600 mt-1">Dwi Anggraeni</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- KASI SMK -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-center mb-6">
                        <div class="h-16 w-16 mx-auto bg-white/20 rounded-full mb-3 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">EM</span>
                        </div>
                        <p class="text-base font-bold">KASI SMK</p>
                        <p class="text-sm text-sky-100">Evi Murti Hidayati</p>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white/5 rounded-xl p-4 text-center">
                            <div class="h-12 w-12 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                <span class="text-sm font-bold">PN</span>
                            </div>
                            <p class="text-xs font-semibold">Penata Administrasi</p>
                            <p class="text-xs text-sky-100">Prasetyo Nugroho</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 text-center">
                            <div class="h-12 w-12 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                <span class="text-sm font-bold">WB</span>
                            </div>
                            <p class="text-xs font-semibold">Pengola Administrasi</p>
                            <p class="text-xs text-sky-100">Windah Basudarah</p>
                        </div>
                    </div>
                </div>

                <!-- KASI SMA -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-center mb-6">
                        <div class="h-16 w-16 mx-auto bg-white/20 rounded-full mb-3 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">EM</span>
                        </div>
                        <p class="text-base font-bold">KASI SMA</p>
                        <p class="text-sm text-sky-100">Evi Murti Hidayati</p>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white/5 rounded-xl p-4 text-center">
                            <div class="h-12 w-12 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                <span class="text-sm font-bold">PN</span>
                            </div>
                            <p class="text-xs font-semibold">Penata Administrasi</p>
                            <p class="text-xs text-sky-100">Prasetyo Nugroho</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 text-center">
                            <div class="h-12 w-12 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                <span class="text-sm font-bold">WB</span>
                            </div>
                            <p class="text-xs font-semibold">Pengola Administrasi</p>
                            <p class="text-xs text-sky-100">Windah Basudarah</p>
                        </div>
                    </div>
                </div>

                <!-- KASUB BAG TU -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-center mb-6">
                        <div class="h-16 w-16 mx-auto bg-white/20 rounded-full mb-3 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">EM</span>
                        </div>
                        <p class="text-base font-bold">KASUB BAG TU</p>
                        <p class="text-sm text-sky-100">Evi Murti Hidayati</p>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white/5 rounded-xl p-3 text-center">
                                <div class="h-10 w-10 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                    <span class="text-xs font-bold">PN</span>
                                </div>
                                <p class="text-xs font-semibold">P. Admin</p>
                                <p class="text-xs text-sky-100">P. Nugroho</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-3 text-center">
                                <div class="h-10 w-10 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                    <span class="text-xs font-bold">WB</span>
                                </div>
                                <p class="text-xs font-semibold">P. Admin</p>
                                <p class="text-xs text-sky-100">W. Basudarah</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white/5 rounded-xl p-3 text-center">
                                <div class="h-10 w-10 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                    <span class="text-xs font-bold">PN</span>
                                </div>
                                <p class="text-xs font-semibold">P. Admin</p>
                                <p class="text-xs text-sky-100">P. Nugroho</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-3 text-center">
                                <div class="h-10 w-10 mx-auto bg-white/20 rounded-full mb-2 flex items-center justify-center">
                                    <span class="text-xs font-bold">WB</span>
                                </div>
                                <p class="text-xs font-semibold">P. Admin</p>
                                <p class="text-xs text-sky-100">W. Basudarah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- FOOTER -->
<footer class="bg-slate-900 text-white mt-20">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">E</span>
                    </div>
                    <span class="text-xl font-bold">E-CABDIN</span>
                </div>
                <p class="text-slate-400 text-sm">
                    Cabang Dinas Pendidikan Provinsi Jawa Timur Wilayah Kabupaten Malang
                </p>
            </div>
            
            <div>
                <h4 class="font-bold mb-4"></h4>
                {{-- <ul class="space-y-2 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-sky-400 transition-colors">Administrasi</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition-colors">Perizinan</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition-colors">Konsultasi</a></li>
                </ul> --}}
            </div>
            
            <div>
                <h4 class="font-bold mb-4">Informasi</h4>
                <ul class="space-y-2 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-sky-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition-colors">Kontak</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition-colors">FAQ</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2 text-slate-400 text-sm">
                    <li>Jl. Simpang Ijen No. 2 Oro-oro Dowo, Klojen, Malang</li>
                    <li>Jawa Timur, Indonesia 65119</li>
                    <li class="pt-2">Email: cabdinkabmalang.gmail.com</li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-slate-800 pt-8 text-center text-slate-400 text-sm">
            © 2026 E-Cabdin - Cabang Dinas Pendidikan Kabupaten Malang. All rights reserved.
        </div>
    </div>
</footer>

<script>
    const header = document.getElementById('main-header');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            header.classList.add('shadow-lg');
        } else {
            header.classList.remove('shadow-lg');
        }
    });

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

</body>
</html>