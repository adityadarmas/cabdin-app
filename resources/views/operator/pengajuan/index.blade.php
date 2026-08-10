@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-800">Pengajuan Sekolah</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih jenis pengajuan untuk melihat riwayat dan membuat pengajuan baru.</p>
        </div>

        @if ($notifikasi->isNotEmpty())
            <section class="mb-6 overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm">
                <div class="flex items-center justify-between bg-blue-50 px-5 py-3"><h2 class="text-sm font-extrabold text-blue-800">Notifikasi Terbaru</h2><a href="{{ route('operator.notifikasi.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat semua</a></div>
                <div class="divide-y divide-slate-100">
                    @foreach ($notifikasi as $notification)
                        <a href="{{ $notification->data['url'] ?? route('operator.pengajuan.index') }}" class="block px-5 py-3 transition hover:bg-slate-50"><p class="text-sm font-bold text-slate-700">{{ $notification->data['title'] ?? 'Pembaruan pengajuan' }}</p><p class="mt-1 text-xs text-slate-500">{{ $notification->data['message'] ?? '' }}</p></a>
                    @endforeach
                </div>
            </section>
        @endif

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($jenisPengajuans as $jenis)
                <a href="{{ route('operator.pengajuan.jenis', $jenis) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg">
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-blue-50 text-sm font-extrabold text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white">{{ $loop->iteration }}</div>
                    <h2 class="mt-4 text-base font-extrabold leading-6 text-slate-800">{{ $jenis->nama }}</h2>
                    <p class="mt-2 min-h-10 text-xs leading-5 text-slate-500">{{ $jenis->deskripsi ?: 'Klik untuk melihat riwayat dan membuat pengajuan.' }}</p>
                    <span class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-blue-600">Buka pengajuan <span aria-hidden="true">→</span></span>
                </a>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-400 md:col-span-2 xl:col-span-3">Belum ada jenis pengajuan aktif. Hubungi admin.</div>
            @endforelse
        </div>
    </div>
@endsection
