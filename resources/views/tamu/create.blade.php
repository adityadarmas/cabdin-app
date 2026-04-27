<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tamu</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-100 text-slate-800">

<div class="max-w-5xl mx-auto py-10 px-6 space-y-10">
    <div class="flex-1">
            <h1 class="text-2xl font-semibold text-slate-900">
                Cabang Dinas Pendidikan Provinsi Jawa Timur
            </h1>
            <h2 class="text-5xl font-bold text-slate-900">
                Wilayah Kabupaten Malang
            </h2>
            <p class="text-sm text-slate-500 mt-4 max-w-md">
                Kami melayani administrasi pendidikan menengah atas
                di wilayah Kabupaten Malang secara digital dan terintegrasi.
            </p>
    </div>
    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- ALERT ERROR -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">
            Tambah Tamu
        </h3>

        <form action="{{ route('tamu.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                >
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat/Asal</label>
                <input
                    type="text"
                    name="asal"
                    value="{{ old('asal') }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                >
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Keperluan</label>
                <textarea
                    name="keperluan"
                    rows="3"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                >{{ old('keperluan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nomor HP / WhatsApp</label>
                <input
                    type="text"
                    name="nomor_hp"
                    value="{{ old('nomor_hp') }}"
                    placeholder="Contoh: 08123456789"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                >
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-sky-500 hover:bg-sky-400 text-white px-6 py-2 rounded-lg text-sm font-medium shadow"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- DAFTAR TAMU -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">
                Daftar Tamu Sebelumnya
            </h3>
        </div>

        <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Asal</th>
                    <th class="px-4 py-3 text-left">Keperluan</th>
                    <th class="px-4 py-3 text-left">No. HP</th>
                    {{-- <th class="px-4 py-3 text-center">Aksi</th> --}}
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($tamu as $item)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium">{{ $item->nama }}</td>
                    <td class="px-4 py-3">{{ $item->asal }}</td>
                    <td class="px-4 py-3">{{ $item->keperluan }}</td>
                    <td class="px-4 py-3">{{ $item->nomor_hp ?? '-' }}</td>
                    {{-- <td class="px-4 py-3 text-center">
                        <a
                            href="{{ route('tamu.edit', $item) }}"
                            class="inline-block bg-amber-400 hover:bg-amber-300 text-white px-3 py-1 rounded-md text-xs"
                        >
                            Edit
                        </a>
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-slate-400">
                        Belum ada data tamu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div>
        {{ $tamu->links() }}
    </div>

    <section id="produk" class="scroll-mt-24">
    <div class="bg-white rounded-xl p-6 shadow-sm overflow-hidden">

        <h3 class="text-3xl font-bold tracking-wide text-slate-800">
            Produk - Produk
        </h3>
        <p class="text-slate-500 mb-6">
            Sekolah di Kabupaten Malang
        </p>

        <!-- SLIDER CONTAINER -->
        <div class="relative">

            <!-- PREV BUTTON -->
            <button id="prevBtn"
                class="absolute left-2 top-1/2 -translate-y-1/2 z-10
                       bg-white/80 hover:bg-white shadow rounded-full p-2">
                ❮
            </button>

            <!-- NEXT BUTTON -->
            <button id="nextBtn"
                class="absolute right-2 top-1/2 -translate-y-1/2 z-10
                       bg-white/80 hover:bg-white shadow rounded-full p-2">
                ❯
            </button>

            <!-- SLIDES -->
            <div id="product-slider"
                 class="flex transition-transform duration-700 ease-in-out">

                <!-- SLIDE 1 -->
                <div class="min-w-full flex items-center justify-between gap-4 px-6">
                    <img src="/images/dumbel.png" class="h-50 w-50 object-contain">
                    <div class="flex-1 text-left">
                        <h4 class="text-5xl font-bold">Dumbell 5 Kg</h4>
                        <p class="text-lg text-slate-600">Produk dari SMKN 1 Singosari</p>
                        <p class="text-xs text-slate-400">
                            produksi siswa smk 1 singosari yang telah lulus uji tes bertekanan tinggi
                        </p>
                        <button class="mt-2 bg-sky-500 hover:bg-sky-400 text-white text-xs px-4 py-1.5 rounded-lg">
                            Berminat?
                        </button>
                    </div>
                </div>

                <!-- SLIDE 2 -->
                <div class="min-w-full flex items-center justify-between gap-4 px-6">
                    <div class="flex-1 text-right">
                        <h4 class="text-5xl font-bold">Dumbell 5 Kg</h4>
                        <p class="text-lg text-slate-600">Produk dari SMKN 1 Singosari</p>
                        <p class="text-xs text-slate-400">
                            produksi siswa smk 1 singosari yang telah lulus uji tes bertekanan tinggi
                        </p>
                        <button class="mt-2 bg-sky-500 hover:bg-sky-400 text-white text-xs px-4 py-1.5 rounded-lg">
                            Berminat?
                        </button>
                    </div>
                    <img src="/images/dumbel.png" class="h-50 w-50 object-contain">
                </div>

                <!-- SLIDE 3 -->
                <div class="min-w-full flex items-center justify-between gap-4 px-6">
                    <img src="/images/dumbel.png" class="h-50 w-50 object-contain">
                    <div class="flex-1 text-left">
                        <h4 class="text-5xl font-bold">Dumbell 5 Kg</h4>
                        <p class="text-lg text-slate-600">Produk dari SMKN 1 Singosari</p>
                        <p class="text-xs text-slate-400">
                            produksi siswa smk 1 singosari yang telah lulus uji tes bertekanan tinggi
                        </p>
                        <button class="mt-2 bg-sky-500 hover:bg-sky-400 text-white text-xs px-4 py-1.5 rounded-lg">
                            Berminat?
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

</div>

</body>

<script>
    const slider = document.getElementById('product-slider');
    const slides = slider.children;
    const totalSlides = slides.length;

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let index = 0;
    let interval;

    function showSlide(i) {
        index = (i + totalSlides) % totalSlides;
        slider.style.transform = `translateX(-${index * 100}%)`;
    }

    function startAutoSlide() {
        interval = setInterval(() => {
            showSlide(index + 1);
        }, 4000);
    }

    function stopAutoSlide() {
        clearInterval(interval);
    }

    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        showSlide(index + 1);
        startAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        showSlide(index - 1);
        startAutoSlide();
    });

    startAutoSlide();
</script>

</html>
