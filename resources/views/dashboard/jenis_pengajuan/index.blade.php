@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Jenis Pengumpulan Data</h1>
                <p class="mt-1 text-sm text-slate-500">Nonaktifkan jenis yang sudah tidak dipakai. Jenis dengan riwayat data tidak dapat dihapus.</p>
            </div>
            <a href="{{ route('jenis-pengajuan.create') }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">+ Tambah Jenis</a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Urutan</th>
                        <th class="px-5 py-4">Jenis & Petunjuk</th>
                        <th class="px-5 py-4">Kategori</th>
                        <th class="px-5 py-4">Data</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jenisPengajuans as $item)
                        <tr>
                            <td class="px-5 py-4 font-bold text-blue-600">{{ $item->urutan }}</td>
                            <td class="px-5 py-4">
                                <p class="font-bold text-slate-800">{{ $item->nama }}</p>
                                <p class="mt-1 max-w-2xl text-xs leading-5 text-slate-500">{{ $item->deskripsi ? \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 140) : 'Belum ada petunjuk.' }}</p>
                            </td>
                            <td class="px-5 py-4"><span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">{{ $item->kategoriPengajuan?->nama ?? '-' }}</span></td>
                            <td class="px-5 py-4"><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">{{ $item->pengajuans_count }} data</span></td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a class="text-xs font-bold text-blue-600 hover:underline" href="{{ route('jenis-pengajuan.edit', $item) }}">Edit / Nonaktifkan</a>
                                @if ($item->pengajuans_count === 0)
                                    <form class="inline" method="POST" action="{{ route('jenis-pengajuan.destroy', $item) }}" onsubmit="return confirm('Hapus jenis pengumpulan data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="ml-3 text-xs font-bold text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @else
                                    <span class="ml-3 cursor-not-allowed text-xs font-bold text-slate-300" title="Jenis dengan riwayat data tidak dapat dihapus">Tidak dapat dihapus</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-14 text-center text-slate-400">Belum ada jenis pengumpulan data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
