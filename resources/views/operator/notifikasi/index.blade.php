@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6"><h1 class="text-2xl font-extrabold text-slate-800">Notifikasi</h1><p class="mt-1 text-sm text-slate-500">Pembaruan pengumpulan data dan berita terbaru dari admin.</p></div>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="divide-y divide-slate-100">
                @forelse ($notifications as $notification)
                    <a href="{{ $notification->data['url'] ?? route('operator.pengajuan.index') }}" class="block p-5 transition hover:bg-slate-50">
                        <div class="flex gap-3"><span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full bg-blue-600"></span><div><h2 class="font-extrabold text-slate-800">{{ $notification->data['title'] ?? 'Pembaruan pengumpulan data' }}</h2><p class="mt-1 text-sm leading-6 text-slate-600">{{ $notification->data['message'] ?? '' }}</p><p class="mt-2 text-xs text-slate-400">{{ $notification->created_at->translatedFormat('d F Y, H:i') }}</p></div></div>
                    </a>
                @empty
                    <div class="p-12 text-center text-sm text-slate-400">Belum ada notifikasi.</div>
                @endforelse
            </div>
            @if ($notifications->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $notifications->links() }}</div>@endif
        </section>
    </div>
@endsection
