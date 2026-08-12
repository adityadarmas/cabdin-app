@extends('layouts.app')

@section('content')
    @php
        $statusStyle = [
            'menunggu' => 'bg-amber-100 text-amber-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'disetujui' => 'bg-emerald-100 text-emerald-700',
            'ditolak' => 'bg-red-100 text-red-700',
        ];
        $statusLabel = ['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'];
    @endphp

    <div class="max-w-6xl mx-auto">
        <a href="{{ route('admin.pengajuan.index') }}" class="mb-5 inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600">← Semua jenis pengumpulan data</a>
        <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-blue-600 p-6 text-white shadow-lg">
            <p class="text-xs font-bold uppercase tracking-widest text-blue-100">Antrian Pengumpulan Data</p>
            <h1 class="mt-2 text-2xl font-extrabold">{{ $jenisPengajuan->nama }}</h1>
            @if ($jenisPengajuan->deskripsi)
                <div class="mt-2 max-w-3xl text-sm leading-6 text-blue-100 [&_a]:font-bold [&_a]:underline [&_ol]:ml-5 [&_ol]:list-decimal [&_p]:mb-2 [&_ul]:ml-5 [&_ul]:list-disc">{!! $jenisPengajuan->deskripsi !!}</div>
            @endif
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <form class="flex flex-wrap items-center gap-3" method="GET">
                <select name="status" class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm">
                    <option value="">Semua status</option>
                    @foreach ($statusLabel as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50">Filter</button>
                @if (request('status'))
                    <a class="text-xs font-bold text-blue-600 hover:underline" href="{{ route('admin.pengajuan.jenis', $jenisPengajuan) }}">Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.pengajuan.export', ['jenis_pengajuan_id' => $jenisPengajuan->id, 'status' => request('status')]) }}" class="ml-auto rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">Export CSV</a>
        </div>

        @if ($jenisPengajuan->is_tagihan_dashboard)
            @php
                $terkumpul = $rekapTagihan->where('pengumpulan_tagihan_count', '>', 0)->count();
                $dibaca = $rekapTagihan->filter(fn ($operator) => $operator->pengumpulan_tagihan_count === 0 && $operator->tagihanKonfirmasis->isNotEmpty())->count();
            @endphp
            <section class="mt-5 overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-emerald-100 bg-emerald-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div><h2 class="font-extrabold text-emerald-900">Rekap Sekolah Tagihan</h2><p class="mt-1 text-xs text-emerald-700">{{ $terkumpul }} sudah mengumpulkan · {{ $dibaca }} sudah membaca · {{ $rekapTagihan->count() - $terkumpul - $dibaca }} belum ditindaklanjuti</p></div>
                    <span class="text-xs font-bold text-emerald-700">Deadline {{ $jenisPengajuan->deadline_at?->translatedFormat('d M Y, H:i') }}</span>
                </div>
                <div class="overflow-x-auto"><table class="min-w-full text-sm"><thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500"><tr><th class="px-5 py-3">Sekolah</th><th class="px-5 py-3">Operator</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Waktu</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse($rekapTagihan as $operator)<tr><td class="px-5 py-3 font-bold text-slate-700">{{ $operator->nama_sekolah ?: '-' }}</td><td class="px-5 py-3 text-slate-600">{{ $operator->name }}</td><td class="px-5 py-3">@if($operator->pengumpulan_tagihan_count > 0)<span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">Sudah mengumpulkan</span>@elseif($operator->tagihanKonfirmasis->isNotEmpty())<span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">Sudah dibaca</span>@else<span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-bold text-rose-700">Belum ditindaklanjuti</span>@endif</td><td class="px-5 py-3 text-xs text-slate-500">@if($operator->pengumpulan_tagihan_count > 0){{ $operator->pengajuans->first()?->submitted_at?->translatedFormat('d M Y, H:i') }}@elseif($operator->tagihanKonfirmasis->isNotEmpty()){{ $operator->tagihanKonfirmasis->first()->dibaca_at?->translatedFormat('d M Y, H:i') }}@else-@endif</td></tr>@empty<tr><td colspan="4" class="px-5 py-10 text-center text-slate-400">Belum ada operator sekolah.</td></tr>@endforelse</tbody></table></div>
            </section>
        @endif

        <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="font-extrabold text-slate-800">Daftar Pengumpulan Data</h2>
                <span class="text-xs font-semibold text-slate-500">{{ $pengajuans->total() }} data</span>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($pengajuans as $item)
                    <article class="p-5">
                        <div class="flex flex-col gap-5 lg:flex-row lg:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-extrabold text-slate-800">{{ $item->operator?->name ?? 'Operator tidak tersedia' }}</h3>
                                    <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $statusStyle[$item->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $statusLabel[$item->status] ?? ucfirst($item->status) }}</span>
                                </div>
                                <p class="mt-1 text-xs text-slate-500">{{ $item->operator?->nama_sekolah ?: 'Sekolah belum diisi' }} · {{ $item->submitted_at?->translatedFormat('d F Y H:i') }}</p>
                                <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">{{ $item->isi }}</p>
                                @if ($item->lampiran)
                                    <a class="mt-3 inline-flex rounded-lg bg-slate-100 px-3 py-2 text-xs font-bold text-blue-600 hover:bg-blue-50" target="_blank" href="{{ asset('storage/'.$item->lampiran) }}">Buka lampiran</a>
                                @endif
                                <a href="{{ route('admin.pengajuan.show', $item) }}" class="mt-3 inline-flex rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">Lihat detail data</a>
                            </div>

                            <form class="w-full rounded-xl bg-slate-50 p-4 lg:w-80" method="POST" action="{{ route('admin.pengajuan.update', $item) }}">
                                @csrf
                                @method('PUT')
                                <label class="mb-1 block text-xs font-bold text-slate-600">Status Pengumpulan Data</label>
                                <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm" name="status">
                                    @foreach ($statusLabel as $value => $label)
                                        <option value="{{ $value }}" @selected($item->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <label class="mb-1 mt-3 block text-xs font-bold text-slate-600">Keterangan untuk operator</label>
                                <textarea class="min-h-24 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm" name="keterangan_admin" placeholder="Tambahkan catatan atau alasan status...">{{ $item->keterangan_admin }}</textarea>
                                <button class="mt-3 w-full rounded-lg bg-blue-600 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Simpan Status</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="p-12 text-center text-sm text-slate-400">Belum ada data untuk jenis ini.</div>
                @endforelse
            </div>
            @if ($pengajuans->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">{{ $pengajuans->links() }}</div>
            @endif
        </section>
    </div>
@endsection
