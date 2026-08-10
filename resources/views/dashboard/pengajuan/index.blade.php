@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-800">Pengajuan Operator</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih jenis pengajuan untuk meninjau antrian dan memperbarui statusnya.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($jenisPengajuans as $jenis)
                <a href="{{ route('admin.pengajuan.jenis', $jenis) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg">
                    <div class="flex items-start justify-between gap-4">
                        <div class="grid h-11 w-11 place-items-center rounded-xl bg-blue-50 text-sm font-extrabold text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white">{{ $loop->iteration }}</div>
                        @if ($jenis->menunggu_pengajuans_count)
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-extrabold text-amber-700">{{ $jenis->menunggu_pengajuans_count }} menunggu</span>
                        @else
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-extrabold text-emerald-700">Tidak ada antrian</span>
                        @endif
                    </div>
                    <h2 class="mt-4 text-base font-extrabold leading-6 text-slate-800">{{ $jenis->nama }}</h2>
                    <p class="mt-2 min-h-10 text-xs leading-5 text-slate-500">{{ $jenis->deskripsi ?: 'Buka untuk meninjau pengajuan operator.' }}</p>
                    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="text-xs font-semibold text-slate-500">{{ $jenis->total_pengajuans_count }} total pengajuan</span>
                        <span class="text-xs font-bold text-blue-600">Buka antrian →</span>
                    </div>
                </a>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-400 md:col-span-2 xl:col-span-3">Belum ada jenis pengajuan.</div>
            @endforelse
        </div>
    </div>
@endsection
