@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-800">Deadline Pengumpulan Data</h1>
        <p class="mt-1 text-sm text-slate-500">Tandai tagihan yang sudah dibaca atau buka form untuk mengumpulkan data.</p>
    </div>

    <div class="space-y-4">
        @forelse($tagihans as $item)
            @php($selesai = $item->sudah_dikumpulkan || $item->sudah_dibaca)
            <article class="rounded-2xl border p-5 shadow-sm {{ $selesai ? 'border-emerald-200 bg-emerald-50' : 'border-rose-200 bg-white' }}">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-extrabold text-slate-800">{{ $item->nama }}</h2>
                            @if($item->sudah_dikumpulkan)
                                <span class="rounded-full bg-emerald-600 px-2.5 py-1 text-xs font-bold text-white">Data sudah dikumpulkan</span>
                            @elseif($item->sudah_dibaca)
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">Sudah dibaca</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-bold text-rose-700">Perlu ditindaklanjuti</span>
                            @endif
                        </div>
                        <div class="mt-2 max-w-3xl text-sm leading-6 text-slate-600 [&_a]:font-bold [&_a]:text-blue-600 [&_a]:underline [&_blockquote]:border-l-4 [&_blockquote]:border-slate-300 [&_blockquote]:pl-4 [&_ol]:ml-5 [&_ol]:list-decimal [&_p]:mb-2 [&_p:last-child]:mb-0 [&_ul]:ml-5 [&_ul]:list-disc">{!! $item->deskripsi !!}</div>
                        <p class="mt-3 text-xs font-bold {{ $selesai ? 'text-emerald-700' : 'text-rose-700' }}">Deadline {{ $item->deadline_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                    <div class="flex shrink-0 flex-wrap gap-2">
                        <a href="{{ route('operator.pengajuan.jenis', $item) }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">{{ $item->sudah_dikumpulkan ? 'Lihat data' : 'Kumpulkan data' }}</a>
                        @unless($item->sudah_dibaca || $item->sudah_dikumpulkan)
                            <form method="POST" action="{{ route('operator.tagihan.confirm', $item) }}">
                                @csrf
                                <button class="rounded-lg border border-emerald-300 bg-white px-4 py-2.5 text-sm font-bold text-emerald-700 hover:bg-emerald-100">Tandai sudah dibaca</button>
                            </form>
                        @elseif($item->sudah_dibaca && ! $item->sudah_dikumpulkan)
                            <form method="POST" action="{{ route('operator.tagihan.cancel-confirmation', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg border border-amber-300 bg-white px-4 py-2.5 text-sm font-bold text-amber-700 hover:bg-amber-100">Batal tandai dibaca</button>
                            </form>
                        @endunless
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-sm text-slate-400">Tidak ada deadline pengumpulan data aktif.</div>
        @endforelse
    </div>
</div>
@endsection
