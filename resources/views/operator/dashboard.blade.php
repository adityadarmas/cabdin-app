@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-extrabold uppercase tracking-[.16em] text-blue-600">Dashboard Operator</p><h1 class="mt-2 text-2xl font-extrabold text-slate-800">Informasi Sekolah</h1><p class="mt-1 text-sm text-slate-500">Pantau pembaruan pengumpulan data dan pengumuman terbaru dari admin.</p></div><a href="{{ route('operator.pengajuan.index') }}" class="w-fit rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Menu</a></div>

        <div class="space-y-6">
            <section class="overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm">
                <div class="flex items-center justify-between bg-blue-50 px-5 py-4"><div><h2 class="font-extrabold text-blue-900">Notifikasi Terbaru</h2><p class="mt-0.5 text-xs text-blue-700">Pembaruan pengumpulan data dan berita dari admin</p></div><a href="{{ route('operator.notifikasi.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat semua</a></div>
                <div class="divide-y divide-slate-100">
                    @forelse ($notifikasi as $notification)
                        <a href="{{ $notification->data['url'] ?? route('operator.pengajuan.index') }}" class="block p-5 transition hover:bg-slate-50"><div class="flex gap-3"><span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full {{ is_null($notification->read_at) ? 'bg-blue-600' : 'bg-slate-300' }}"></span><div><h3 class="text-sm font-extrabold text-slate-700">{{ $notification->data['title'] ?? 'Pembaruan pengajuan' }}</h3><p class="mt-1 text-xs leading-5 text-slate-500">{{ $notification->data['message'] ?? '' }}</p><p class="mt-2 text-[11px] text-slate-400">{{ $notification->created_at->translatedFormat('d M Y, H:i') }}</p></div></div></a>
                    @empty
                        <div class="p-10 text-center text-sm text-slate-400">Belum ada notifikasi pengumpulan data.</div>
                    @endforelse
                </div>
            </section>

            <div class="grid gap-6 lg:grid-cols-2">
                <section class="overflow-hidden rounded-2xl border border-amber-100 bg-white shadow-sm"><div class="bg-amber-50 px-5 py-4"><h2 class="font-extrabold text-amber-900">Pengumuman</h2><p class="mt-0.5 text-xs text-amber-700">Informasi terbaru dari Cabang Dinas</p></div><div class="divide-y divide-slate-100">@forelse ($pengumumans as $pengumuman)<article class="p-5"><h3 class="text-sm font-extrabold text-slate-800">{{ $pengumuman->judul }}</h3><p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $pengumuman->isi }}</p><p class="mt-3 text-[11px] font-semibold text-slate-400">{{ $pengumuman->published_at?->translatedFormat('d F Y, H:i') ?? 'Baru diterbitkan' }}</p></article>@empty<div class="p-10 text-center text-sm text-slate-400">Belum ada pengumuman saat ini.</div>@endforelse</div></section>
            <section class="overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm"><div class="flex items-center justify-between bg-rose-50 px-5 py-4"><div><div class="flex items-center gap-2"><h2 class="font-extrabold text-rose-900">Tagihan</h2><span class="rounded-full bg-rose-600 px-2.5 py-1 text-xs font-extrabold text-white">{{ $tagihans->count() }} aktif</span></div><p class="mt-0.5 text-xs text-rose-700">Deadline pengumpulan data yang perlu ditindaklanjuti</p></div><a href="{{ route('operator.tagihan.index') }}" class="text-xs font-bold text-rose-700 hover:underline">Lihat semua</a></div><div class="p-5">@forelse($tagihans as $tagihan)<a href="{{ route('operator.tagihan.index') }}" data-billing-slide data-deadline-seconds="{{ $tagihan->deadline_at->timestamp }}" class="{{ $loop->first ? '' : 'hidden' }} block rounded-xl {{ ($tagihan->sudah_dikumpulkan || $tagihan->sudah_dibaca) ? 'bg-gradient-to-br from-emerald-600 to-teal-500' : 'bg-gradient-to-br from-rose-600 to-orange-500' }} p-5 text-white"><p class="text-xs font-bold uppercase tracking-wider text-white/75">{{ $tagihan->sudah_dikumpulkan ? 'Data sudah dikumpulkan' : ($tagihan->sudah_dibaca ? 'Tagihan sudah dibaca' : 'Deadline Pengumpulan Data') }}</p><h3 class="mt-2 text-lg font-extrabold">{{ $tagihan->nama }}</h3><p class="mt-2 line-clamp-2 text-sm leading-6 text-white/85">{{ \Illuminate\Support\Str::limit(strip_tags($tagihan->deskripsi), 145) }}</p><div class="mt-5 grid grid-cols-3 gap-2 text-center"><div class="rounded-lg bg-white/15 p-2"><b data-days class="block text-xl">0</b><span class="text-[10px] font-bold uppercase text-white/75">Hari</span></div><div class="rounded-lg bg-white/15 p-2"><b data-hours class="block text-xl">0</b><span class="text-[10px] font-bold uppercase text-white/75">Jam</span></div><div class="rounded-lg bg-white/15 p-2"><b data-minutes class="block text-xl">0</b><span class="text-[10px] font-bold uppercase text-white/75">Menit</span></div></div></a>@empty<div class="p-10 text-center text-sm text-slate-400">Tidak ada deadline pengumpulan data aktif.</div>@endforelse</div></section>
            </div>

            <section class="overflow-hidden rounded-2xl border border-violet-100 bg-white shadow-sm">
                <div class="bg-violet-50 px-5 py-4"><h2 class="font-extrabold text-violet-900">Panduan Operator</h2><p class="mt-0.5 text-xs text-violet-700">Artikel dan video untuk membantu penggunaan layanan.</p></div>
                <div class="grid gap-4 p-5 md:grid-cols-2 xl:grid-cols-3">@forelse($panduans as $panduan)<article class="rounded-xl border border-slate-200 bg-white p-4"><div class="flex items-center gap-2"><span class="rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider {{ $panduan->tipe === 'video' ? 'bg-rose-100 text-rose-700' : 'bg-violet-100 text-violet-700' }}">{{ $panduan->tipe }}</span></div><h3 class="mt-3 font-extrabold text-slate-800">{{ $panduan->judul }}</h3>@if($panduan->tipe === 'video')<a href="{{ $panduan->video_url }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex rounded-lg bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Tonton video →</a>@else<details class="group mt-3"><summary class="cursor-pointer text-xs font-bold text-violet-700">Baca artikel</summary><div class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $panduan->konten }}</div></details>@endif</article>@empty<div class="py-8 text-center text-sm text-slate-400 md:col-span-2 xl:col-span-3">Belum ada panduan yang tersedia.</div>@endforelse</div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const initBillingCountdown = () => {
    const slides = Array.from(document.querySelectorAll('[data-billing-slide]'));
    if (!slides.length) return;
    const tick = () => {
        slides.forEach((slide) => {
            const deadline = Number(slide.dataset.deadlineSeconds) * 1000;
            const minutes = Math.max(0, Math.floor((deadline - Date.now()) / 60000));
            slide.querySelector('[data-days]').textContent = Math.floor(minutes / 1440);
            slide.querySelector('[data-hours]').textContent = Math.floor((minutes % 1440) / 60);
            slide.querySelector('[data-minutes]').textContent = minutes % 60;
        });
    };
    tick();
    setInterval(tick, 1000);
    if (slides.length > 1) { let current = 0; setInterval(() => { slides[current].classList.add('hidden'); current = (current + 1) % slides.length; slides[current].classList.remove('hidden'); }, 5000); }
};
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initBillingCountdown);
else initBillingCountdown();
</script>
@endpush
