@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Kategori Prosedur</h1>
        <a href="{{ route('kategori-prosedur.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Kategori
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
                    <th class="px-4 py-2 text-left">Urutan</th>
                    <th class="px-4 py-2 text-left">Nama Kategori</th>
                    <th class="px-4 py-2 text-center">Sub-Prosedur</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2 text-gray-500">{{ $item->urutan }}</td>
                        <td class="px-4 py-2 font-medium">{{ $item->nama }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                {{ $item->prosedurs_count }} prosedur
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if ($item->is_active)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('kategori-prosedur.edit', $item) }}"
                               class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('kategori-prosedur.destroy', $item) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus kategori ini? Semua prosedur dalam kategori ini akan kehilangan kategorinya.')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            Belum ada kategori prosedur
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-gray-500">Kelola sub-prosedur di halaman Manajemen Prosedur</p>
        <a href="{{ route('prosedur.index') }}"
           class="text-blue-600 hover:underline text-sm">
            → Manajemen Prosedur
        </a>
    </div>

</div>
@endsection
