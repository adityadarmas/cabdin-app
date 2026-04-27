@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('operator.produk.index') }}"
           class="text-gray-500 hover:text-gray-800">&#8592; Kembali</a>
        <h1 class="text-2xl font-bold">Detail Produk</h1>
    </div>

    <div class="bg-white rounded shadow p-6 space-y-4">

        @if ($produk->gambar)
            <div>
                <img src="{{ asset('storage/' . $produk->gambar) }}"
                     alt="{{ $produk->nama }}"
                     class="w-full max-h-64 object-cover rounded">
            </div>
        @endif

        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold">Nama Produk</p>
            <p class="text-lg font-medium">{{ $produk->nama }}</p>
        </div>

        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold">Deskripsi</p>
            <p class="text-gray-700">{{ $produk->deskripsi }}</p>
        </div>

        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold">Harga</p>
            <p class="text-gray-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
        </div>

        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold">Status</p>
            @if ($produk->is_active)
                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Aktif</span>
            @else
                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Menunggu Aktivasi</span>
            @endif
        </div>

        <div class="flex gap-3 pt-4 border-t">
            <a href="{{ route('operator.produk.edit', $produk) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Edit
            </a>
            <form action="{{ route('operator.produk.destroy', $produk) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Hapus
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
