@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('operator.produk.index') }}"
           class="text-gray-500 hover:text-gray-800">&#8592; Kembali</a>
        <h1 class="text-2xl font-bold">Edit Produk</h1>
    </div>

    <form action="{{ route('operator.produk.update', $produk) }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Nama Produk</label>
            <input type="text" name="nama"
                   value="{{ old('nama', $produk->nama) }}"
                   class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
            @error('nama')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Kategori</label>
            <select name="kategori" class="w-full border rounded px-3 py-2 @error('kategori') border-red-500 @enderror">
                <option value="jasa"      {{ old('kategori', $produk->kategori) == 'jasa'      ? 'selected' : '' }}>🛠️ Jasa</option>
                <option value="makanan"   {{ old('kategori', $produk->kategori) == 'makanan'   ? 'selected' : '' }}>🍱 Makanan</option>
                <option value="minuman"   {{ old('kategori', $produk->kategori) == 'minuman'   ? 'selected' : '' }}>🥤 Minuman</option>
                <option value="kerajinan" {{ old('kategori', $produk->kategori) == 'kerajinan' ? 'selected' : '' }}>🎨 Kerajinan</option>
                <option value="pertanian" {{ old('kategori', $produk->kategori) == 'pertanian' ? 'selected' : '' }}>🌱 Pertanian</option>
                <option value="teknologi" {{ old('kategori', $produk->kategori) == 'teknologi' ? 'selected' : '' }}>💻 Teknologi</option>
                <option value="lainnya"   {{ old('kategori', $produk->kategori) == 'lainnya'   ? 'selected' : '' }}>📦 Lainnya</option>
            </select>
            @error('kategori')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                      class="w-full border rounded px-3 py-2 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Harga</label>
            <input type="number" name="harga"
                   value="{{ old('harga', $produk->harga) }}"
                   class="w-full border rounded px-3 py-2 @error('harga') border-red-500 @enderror">
            @error('harga')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Gambar Baru (Opsional)</label>
            @if ($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}"
                     class="w-32 h-32 object-cover rounded mb-2">
            @endif
            <input type="file" name="gambar"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Status</label>
            <select name="is_active" class="w-full border rounded px-3 py-2">
                <option value="1" {{ $produk->is_active ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$produk->is_active ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3 pt-4 border-t">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
            <a href="{{ route('operator.produk.index') }}"
               class="px-4 py-2 rounded border hover:bg-gray-100">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
