@extends('layouts.admin')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Produk</h1>
        <a href="{{ route('produk.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Harga</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-2 font-medium">{{ $item->nama }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            @if ($item->is_active)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">

                            {{-- Tampilkan --}}
                            <a href="{{ route('operator.produk.show', $item) }}"
                               class="text-green-600 hover:underline">
                                Lihat
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('operator.produk.edit', $item) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('operator.produk.destroy', $item) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            Belum ada produk yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>
@endsection
