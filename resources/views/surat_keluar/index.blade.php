@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-slate-800">Daftar Surat Keluar</h3>
            @can('create', App\Models\SuratKeluar::class)
                <a href="{{ route('surat-keluar.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                    + Catat Surat Keluar
                </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-12">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Nomor Surat</th>
                        <th class="px-4 py-3 text-left font-semibold">Judul Surat</th>
                        <th class="px-4 py-3 text-left font-semibold w-36">Tanggal Terbit</th>
                        <th class="px-4 py-3 text-left font-semibold w-36">Dicatat Oleh</th>
                        <th class="px-4 py-3 text-left font-semibold w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($suratKeluar as $surat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-600">
                                {{ $loop->iteration + ($suratKeluar->currentPage() - 1) * $suratKeluar->perPage() }}
                            </td>
                            <td class="px-4 py-3 text-slate-800 font-medium">
                                {{ $surat->nomor_surat }}
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                {{ Str::limit($surat->judul_surat, 60) }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $surat->tanggal_terbit ? $surat->tanggal_terbit->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $surat->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    @can('update', $surat)
                                        <a href="{{ route('surat-keluar.edit', $surat) }}"
                                           class="px-3 py-1.5 rounded-md bg-amber-500 text-white hover:bg-amber-600 transition text-xs">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete', $surat)
                                        <form action="{{ route('surat-keluar.destroy', $surat) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus surat ini?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 transition text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-4xl">📤</span>
                                    <p class="font-medium">Belum ada data surat keluar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratKeluar->hasPages())
            <div class="mt-6">
                {{ $suratKeluar->links() }}
            </div>
        @endif

    </div>
@endsection
