@extends('layouts.admin')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Produk</h1>
            @if(auth()->user()->nama_sekolah)
                <p class="mt-1">
                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-100 px-3 py-0.5 rounded-full text-xs font-medium">
                        &#127983; {{ auth()->user()->nama_sekolah }}
                    </span>
                </p>
            @endif
        </div>
        <a href="{{ route('produk.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm">
            + Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $item->nama }}</td>
                            <td class="px-4 py-3 text-gray-700">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if ($item->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span> Menunggu Review
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('operator.produk.show', $item) }}"
                                       class="text-green-600 hover:text-green-800 text-xs font-medium hover:underline">
                                        Lihat
                                    </a>
                                    <a href="{{ route('operator.produk.edit', $item) }}"
                                       class="text-blue-600 hover:text-blue-800 text-xs font-medium hover:underline">
                                        Edit
                                    </a>
                                    <form action="{{ route('operator.produk.destroy', $item) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                                <p class="text-4xl mb-3">&#128230;</p>
                                <p class="font-medium text-gray-500">Belum ada produk</p>
                                <p class="text-xs mt-1">Mulai tambahkan produk sekolah Anda</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>
@endsection
