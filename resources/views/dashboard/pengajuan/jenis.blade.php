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
                $belumTerkumpul = $rekapTagihan->count() - $terkumpul;
                $sekolahTerkumpul = $rekapTagihan->filter(fn ($operator) => $operator->pengumpulan_tagihan_count > 0);
                $sekolahBelumTerkumpul = $rekapTagihan->filter(fn ($operator) => $operator->pengumpulan_tagihan_count === 0);
            @endphp
            <section class="mt-5 overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-emerald-100 bg-emerald-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div><h2 class="font-extrabold text-emerald-900">Rekap Sekolah Tagihan</h2><p class="mt-1 text-xs text-emerald-700">Klik kartu status untuk melihat detail sekolah.</p></div>
                    <span class="text-xs font-bold text-emerald-700">Deadline {{ $jenisPengajuan->deadline_at?->translatedFormat('d M Y, H:i') }}</span>
                </div>
                <div class="grid gap-3 p-5 sm:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4"><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Jumlah Sekolah</p><p class="mt-2 text-3xl font-extrabold text-slate-800">{{ $rekapTagihan->count() }}</p><p class="mt-1 text-xs text-slate-500">Sekolah operator terdaftar</p></div>
                    <details class="group rounded-xl border border-emerald-200 bg-emerald-50 p-4"><summary class="cursor-pointer list-none"><p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Sudah Mengumpulkan</p><div class="mt-2 flex items-end justify-between gap-3"><p class="text-3xl font-extrabold text-emerald-800">{{ $terkumpul }}</p><span class="text-xs font-bold text-emerald-700 group-open:hidden">Lihat detail</span><span class="hidden text-xs font-bold text-emerald-700 group-open:inline">Tutup detail</span></div></summary><div class="mt-4 border-t border-emerald-200 pt-3">@forelse($sekolahTerkumpul as $operator)<div class="flex items-center justify-between gap-3 py-2 text-sm"><div><p class="font-bold text-slate-700">{{ $operator->nama_sekolah ?: '-' }}</p><p class="text-xs text-slate-500">{{ $operator->name }}</p></div><span class="shrink-0 text-right text-xs text-emerald-700">{{ $operator->pengajuans->first()?->submitted_at?->translatedFormat('d M Y, H:i') }}</span></div>@empty<p class="text-sm text-slate-500">Belum ada sekolah yang mengumpulkan.</p>@endforelse</div></details>
                    <details class="group rounded-xl border border-rose-200 bg-rose-50 p-4"><summary class="cursor-pointer list-none"><p class="text-xs font-bold uppercase tracking-wider text-rose-700">Belum Mengumpulkan</p><div class="mt-2 flex items-end justify-between gap-3"><p class="text-3xl font-extrabold text-rose-800">{{ $belumTerkumpul }}</p><span class="text-xs font-bold text-rose-700 group-open:hidden">Lihat detail</span><span class="hidden text-xs font-bold text-rose-700 group-open:inline">Tutup detail</span></div></summary><div class="mt-4 border-t border-rose-200 pt-3">@forelse($sekolahBelumTerkumpul as $operator)<div class="flex items-center justify-between gap-3 py-2 text-sm"><div><p class="font-bold text-slate-700">{{ $operator->nama_sekolah ?: '-' }}</p><p class="text-xs text-slate-500">{{ $operator->name }}</p></div>@if($operator->tagihanKonfirmasis->isNotEmpty())<span class="shrink-0 rounded-full bg-amber-100 px-2 py-1 text-[10px] font-bold text-amber-700">Sudah dibaca</span>@else<span class="shrink-0 rounded-full bg-rose-100 px-2 py-1 text-[10px] font-bold text-rose-700">Belum dibaca</span>@endif</div>@empty<p class="text-sm text-slate-500">Semua sekolah sudah mengumpulkan.</p>@endforelse</div></details>
                </div>
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
                                @if (filled($item->isi))
                                    <div class="mt-4 rounded-xl bg-slate-50 p-4"><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Keterangan</p><p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $item->isi }}</p></div>
                                @endif
                                @if (!empty($item->data_tambahan))
                                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                        @foreach ($item->data_tambahan as $key => $value)
                                            @continue(blank($value))
                                            @php($field = collect($jenisPengajuan->form_fields ?? [])->firstWhere('key', $key))
                                            <div class="rounded-xl border border-slate-100 bg-white p-3"><p class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $field['label'] ?? \Illuminate\Support\Str::of($key)->replace('_', ' ')->title() }}</p><p class="mt-1 whitespace-pre-line break-words text-sm font-semibold leading-6 text-slate-700">{{ is_array($value) ? implode(', ', $value) : $value }}</p></div>
                                        @endforeach
                                    </div>
                                @endif
                                @if ($item->lampiran)
                                    <a class="mt-3 inline-flex rounded-lg bg-slate-100 px-3 py-2 text-xs font-bold text-blue-600 hover:bg-blue-50" target="_blank" href="{{ asset('storage/'.$item->lampiran) }}">Buka lampiran</a>
                                @endif
                                <a href="{{ route('admin.pengajuan.show', $item) }}" class="mt-3 inline-flex rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">Lihat detail &amp; riwayat status</a>
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
