<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Container -->
    <div class="max-w-3xl mx-auto py-12 px-4">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Tambah Produk
                </h1>
                <p class="text-gray-500 mt-1">
                    Silakan isi form berikut untuk menambahkan produk baru
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('produk.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Produk
                    </label>
                    <input type="text"
                           name="nama"
                           value="{{ old('nama') }}"
                           placeholder="Contoh: Jasa Service AC"
                           class="w-full rounded-xl border-gray-300 px-4 py-3
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('nama') border-red-500 focus:ring-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500
                                   @error('kategori') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="jasa"       {{ old('kategori') == 'jasa'       ? 'selected' : '' }}>🛠️ Jasa</option>
                        <option value="makanan"    {{ old('kategori') == 'makanan'    ? 'selected' : '' }}>🍱 Makanan</option>
                        <option value="minuman"    {{ old('kategori') == 'minuman'    ? 'selected' : '' }}>🥤 Minuman</option>
                        <option value="kerajinan"  {{ old('kategori') == 'kerajinan'  ? 'selected' : '' }}>🎨 Kerajinan</option>
                        <option value="pertanian"  {{ old('kategori') == 'pertanian'  ? 'selected' : '' }}>🌱 Pertanian</option>
                        <option value="teknologi"  {{ old('kategori') == 'teknologi'  ? 'selected' : '' }}>💻 Teknologi</option>
                        <option value="lainnya"    {{ old('kategori') == 'lainnya'    ? 'selected' : '' }}>📦 Lainnya</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi"
                              rows="4"
                              placeholder="Tuliskan detail produk atau layanan"
                              class="w-full rounded-xl border-gray-300 px-4 py-3
                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                     @error('deskripsi') border-red-500 focus:ring-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Harga
                    </label>
                    <input type="number"
                           name="harga"
                           value="{{ old('harga') }}"
                           placeholder="Contoh: 150000"
                           class="w-full rounded-xl border-gray-300 px-4 py-3
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  @error('harga') border-red-500 focus:ring-red-500 @enderror">
                    @error('harga')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Gambar (Opsional)
                    </label>
                    <input type="file"
                           name="gambar"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:bg-blue-50 file:text-blue-600
                                  hover:file:bg-blue-100">
                </div>

                <!-- Status -->
                {{-- <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Status
                    </label>
                    <select name="is_active"
                            class="w-full rounded-xl border-gray-300 px-4 py-3
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div> --}}

                <!-- Action -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t">
                    {{-- <a href="{{ route('produk.index') }}"
                       class="px-6 py-2.5 rounded-xl border border-gray-300
                              text-gray-700 hover:bg-gray-100 transition">
                        Kembali
                    </a> --}}

                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl
                                   bg-blue-600 text-white font-semibold
                                   hover:bg-blue-700 transition">
                        Simpan Produk
                    </button>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
