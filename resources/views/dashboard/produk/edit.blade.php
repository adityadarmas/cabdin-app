@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">Edit produk</h1>

    <form action="{{ route('produk.update', $produk) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Nama produk</label>
            <input type="text" name="nama"
                   value="{{ old('nama', $produk->nama) }}"
                   class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
        </div>

        <div>
            <label class="block font-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                      class="w-full border rounded px-3 py-2">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Harga</label>
            <input type="number" name="harga"
                   value="{{ old('harga', $produk->harga) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Gambar Baru (Opsional)</label>
            <input type="file" name="gambar"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Status</label>
            <select name="is_active"
                    class="w-full border rounded px-3 py-2">
                <option value="1" {{ $produk->is_active ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ ! $produk->is_active ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('produk.index') }}"
               class="px-4 py-2 rounded border">
                Kembali
            </a>
        </div>

    </form>

</div>
@endsection
