@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Prosedur</h1>
        <div class="flex gap-2">
            <a href="{{ route('kategori-prosedur.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Kelola Kategori
            </a>
            <a href="{{ route('prosedur.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Prosedur
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($kategori as $kat)
        <div class="mb-6 bg-white rounded shadow">
            <div class="flex items-center justify-between px-5 py-3 border-b bg-gray-50 rounded-t">
                <div class="flex items-center gap-3">
                    <h2 class="font-semibold text-gray-800">{{ $kat->nama }}</h2>
                    @if (!$kat->is_active)
                        <span class="text-xs px-2 py-0.5 bg-red-100 text-red-600 rounded">Nonaktif</span>
                    @endif
                </div>
                <span class="text-xs text-gray-500">{{ $kat->prosedurs->count() }} prosedur</span>
            </div>

            {{-- Card jadwal Dapodik khusus kategori Dapodik --}}
            @if (str_contains(strtolower($kat->nama), 'dapodik'))
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 border-b bg-blue-50">
                    @foreach (['edit_ptk' => 'Edit PTK', 'tambah_ptk' => 'Tambah PTK'] as $jenis => $label)
                        @php $jadwal = $dapodikJadwals[$jenis] ?? null; @endphp
                        <div class="bg-white border border-blue-200 rounded-lg p-4 flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600">
                                        @if ($jenis === 'edit_ptk')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="font-semibold text-gray-800 text-sm">{{ $label }}</span>
                                </div>
                                <a href="{{ route('dapodik-jadwal.edit', $jenis) }}"
                                   class="text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>

                            @if ($jadwal && ($jadwal->tanggal_mulai || $jadwal->tanggal_selesai))
                                <div class="text-xs text-gray-600 space-y-1 mt-1">
                                    @if ($jadwal->tanggal_mulai)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-gray-500">Mulai:</span>
                                            <span class="font-medium text-gray-700">
                                                {{ $jadwal->tanggal_mulai->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if ($jadwal->tanggal_selesai)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-gray-500">Selesai:</span>
                                            <span class="font-medium text-gray-700">
                                                {{ $jadwal->tanggal_selesai->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if ($jadwal->keterangan)
                                        <p class="text-gray-500 italic mt-1">{{ $jadwal->keterangan }}</p>
                                    @endif
                                </div>
                            @else
                                <p class="text-xs text-gray-400 italic mt-1">Belum ada jadwal yang diatur</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2 text-left w-12">Urutan</th>
                            <th class="px-4 py-2 text-left">Judul</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kat->prosedurs as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2 text-gray-500">{{ $item->urutan }}</td>
                                <td class="px-4 py-2 font-medium">{{ $item->judul }}</td>
                                <td class="px-4 py-2">
                                    @if ($item->is_active)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('prosedur.edit', $item) }}"
                                       class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('prosedur.destroy', $item) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin hapus prosedur ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-400 italic">
                                    Belum ada prosedur dalam kategori ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white rounded shadow p-8 text-center text-gray-500">
            Belum ada kategori prosedur.
            <a href="{{ route('kategori-prosedur.create') }}" class="text-blue-600 hover:underline ml-1">
                Buat kategori terlebih dahulu
            </a>
        </div>
    @endforelse

</div>
@endsection
