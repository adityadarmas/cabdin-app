@extends('layouts.app')

@section('content')
    @php
        $statusStyle = [
            'menunggu' => 'bg-amber-100 text-amber-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'disetujui' => 'bg-emerald-100 text-emerald-700',
            'ditolak' => 'bg-red-100 text-red-700',
        ];
    @endphp

    <div class="max-w-5xl mx-auto">
        <a href="{{ route('operator.pengajuan.index') }}" class="mb-5 inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600">← Semua jenis pengumpulan data</a>
        <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-blue-600 p-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-100">Jenis Pengumpulan Data</p>
                    <h1 class="mt-2 text-2xl font-extrabold">{{ $jenisPengajuan->nama }}</h1>
                    @if ($jenisPengajuan->deskripsi)
                        <div class="mt-2 max-w-2xl text-sm leading-6 text-blue-100 [&_a]:font-bold [&_a]:underline [&_ol]:ml-5 [&_ol]:list-decimal [&_p]:mb-2 [&_ul]:ml-5 [&_ul]:list-disc">{!! $jenisPengajuan->deskripsi !!}</div>
                    @endif
                </div>
                <a href="{{ route('operator.pengajuan.create', ['jenis' => $jenisPengajuan->id]) }}" class="shrink-0 rounded-xl bg-white px-4 py-3 text-sm font-extrabold text-blue-700 shadow-sm transition hover:bg-blue-50">+ Tambah Data Baru</a>
            </div>
        </div>

        <section class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h2 class="font-extrabold text-slate-800">Riwayat Pengumpulan Data</h2>
                <span class="text-xs font-semibold text-slate-500">{{ $pengajuans->total() }} data terkumpul</span>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($pengajuans as $item)
                    <article class="p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-sm font-extrabold text-slate-700">Dikirim {{ $item->submitted_at?->translatedFormat('d M Y, H:i') }}</p>
                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-500">{{ $item->isi }}</p>
                            </div>
                            <span class="w-fit shrink-0 rounded-full px-3 py-1 text-xs font-bold {{ $statusStyle[$item->status] ?? 'bg-slate-100 text-slate-700' }}">{{ ucfirst($item->status) }}</span>
                        </div>
                        @if ($item->keterangan_admin)
                            <div class="mt-4 rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-600"><span class="font-bold text-slate-700">Keterangan admin:</span> {{ $item->keterangan_admin }}</div>
                        @endif
                        <div class="mt-4 flex flex-wrap gap-x-4 gap-y-2">
                            <a href="{{ route('operator.pengajuan.show', $item) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">Lihat detail</a>
                            @if ($item->lampiran)
                                <a target="_blank" href="{{ asset('storage/'.$item->lampiran) }}" class="text-sm font-bold text-slate-500 hover:text-blue-600">Lihat lampiran</a>
                            @endif
                            @if (in_array($item->status, ['menunggu', 'ditolak']))
                                <a href="{{ route('operator.pengajuan.edit', $item) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">Edit data</a>
                                <form method="POST" action="{{ route('operator.pengajuan.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm font-bold text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="p-10 text-center">
                        <p class="font-bold text-slate-600">Belum ada data terkumpul.</p>
                        <p class="mt-1 text-sm text-slate-500">Kumpulkan data pertama untuk jenis ini melalui tombol di atas.</p>
                    </div>
                @endforelse
            </div>
            @if ($pengajuans->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">{{ $pengajuans->links() }}</div>
            @endif
        </section>
    </div>
@endsection
