@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-extrabold uppercase tracking-[.16em] text-blue-600">Dashboard Operator</p><h1 class="mt-2 text-2xl font-extrabold text-slate-800">Informasi Sekolah</h1><p class="mt-1 text-sm text-slate-500">Pantau pembaruan pengajuan dan pengumuman terbaru dari admin.</p></div><a href="{{ route('operator.pengajuan.index') }}" class="w-fit rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Buka Pengajuan Saya</a></div>

        <div class="space-y-6">
            <section class="overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm">
                <div class="flex items-center justify-between bg-blue-50 px-5 py-4"><div><h2 class="font-extrabold text-blue-900">Notifikasi Pengajuan</h2><p class="mt-0.5 text-xs text-blue-700">Pembaruan dari admin</p></div><a href="{{ route('operator.notifikasi.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat semua</a></div>
                <div class="divide-y divide-slate-100">
                    @forelse ($notifikasi as $notification)
                        <a href="{{ $notification->data['url'] ?? route('operator.pengajuan.index') }}" class="block p-5 transition hover:bg-slate-50"><div class="flex gap-3"><span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full {{ is_null($notification->read_at) ? 'bg-blue-600' : 'bg-slate-300' }}"></span><div><h3 class="text-sm font-extrabold text-slate-700">{{ $notification->data['title'] ?? 'Pembaruan pengajuan' }}</h3><p class="mt-1 text-xs leading-5 text-slate-500">{{ $notification->data['message'] ?? '' }}</p><p class="mt-2 text-[11px] text-slate-400">{{ $notification->created_at->translatedFormat('d M Y, H:i') }}</p></div></div></a>
                    @empty
                        <div class="p-10 text-center text-sm text-slate-400">Belum ada notifikasi pengajuan.</div>
                    @endforelse
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-amber-100 bg-white shadow-sm">
                <div class="bg-amber-50 px-5 py-4"><h2 class="font-extrabold text-amber-900">Pengumuman</h2><p class="mt-0.5 text-xs text-amber-700">Informasi terbaru dari Cabang Dinas</p></div>
                <div class="divide-y divide-slate-100">
                    @forelse ($pengumumans as $pengumuman)
                        <article class="p-5"><h3 class="text-sm font-extrabold text-slate-800">{{ $pengumuman->judul }}</h3><p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $pengumuman->isi }}</p><p class="mt-3 text-[11px] font-semibold text-slate-400">{{ $pengumuman->published_at?->translatedFormat('d F Y, H:i') ?? 'Baru diterbitkan' }}</p></article>
                    @empty
                        <div class="p-10 text-center text-sm text-slate-400">Belum ada pengumuman saat ini.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
