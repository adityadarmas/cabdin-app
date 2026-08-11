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
        $jenis = $pengajuan->jenisPengajuan;
        $fieldLabels = collect($jenis?->form_fields ?? [])->keyBy('key');
    @endphp

    <div class="max-w-5xl mx-auto">
        <a href="{{ $jenis ? route('admin.pengajuan.jenis', $jenis) : route('admin.pengajuan.index') }}" class="mb-5 inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600">← Kembali ke antrian</a>

        <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-gradient-to-r from-blue-700 to-blue-600 p-6 text-white">
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-100">Detail Pengumpulan Data</p>
                    <div class="mt-2 flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold">{{ $jenis?->nama ?? $pengajuan->judul }}</h1>
                            <p class="mt-2 text-sm text-blue-100">Dikirim {{ $pengajuan->submitted_at?->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1.5 text-xs font-extrabold {{ $statusStyle[$pengajuan->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $statusLabel[$pengajuan->status] ?? ucfirst($pengajuan->status) }}</span>
                    </div>
                </div>

                <div class="space-y-6 p-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-700">Data Operator</h2>
                        <dl class="mt-3 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl bg-slate-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Nama Operator</dt><dd class="mt-1 text-sm font-semibold text-slate-700">{{ $pengajuan->operator?->name ?? '-' }}</dd></div>
                            <div class="rounded-xl bg-slate-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Sekolah</dt><dd class="mt-1 text-sm font-semibold text-slate-700">{{ $pengajuan->operator?->nama_sekolah ?? '-' }}</dd></div>
                        </dl>
                    </div>

                    @if (filled($pengajuan->isi))
                        <div class="border-t border-slate-100 pt-6"><h2 class="text-sm font-extrabold text-slate-700">Keterangan Pengumpulan Data</h2><p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-600">{{ $pengajuan->isi }}</p></div>
                    @endif

                    @if (!empty($pengajuan->data_tambahan))
                        <div class="border-t border-slate-100 pt-6">
                            <h2 class="text-sm font-extrabold text-slate-700">Data Form Terkumpul</h2>
                            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                @foreach ($pengajuan->data_tambahan as $key => $value)
                                    <div class="rounded-xl bg-slate-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ data_get($fieldLabels->get($key), 'label', str_replace('_', ' ', $key)) }}</dt><dd class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-700">{{ is_array($value) ? implode(', ', $value) : $value }}</dd></div>
                                @endforeach
                            </dl>
                        </div>
                    @endif

                    @if ($pengajuan->lampiran)
                        <div class="border-t border-slate-100 pt-6"><h2 class="text-sm font-extrabold text-slate-700">Lampiran</h2><a target="_blank" href="{{ asset('storage/'.$pengajuan->lampiran) }}" class="mt-3 inline-flex rounded-lg bg-blue-50 px-4 py-2.5 text-sm font-bold text-blue-700 hover:bg-blue-100">Buka lampiran</a></div>
                    @endif
                </div>
            </section>

            <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-extrabold text-slate-800">Tindak Lanjut Admin</h2>
                <form class="mt-4" method="POST" action="{{ route('admin.pengajuan.update', $pengajuan) }}">
                    @csrf
                    @method('PUT')
                    <label class="mb-1 block text-xs font-bold text-slate-600">Status Pengumpulan Data</label>
                    <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm" name="status">
                        @foreach ($statusLabel as $value => $label)
                            <option value="{{ $value }}" @selected($pengajuan->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <label class="mb-1 mt-4 block text-xs font-bold text-slate-600">Keterangan untuk operator</label>
                    <textarea class="min-h-32 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm" name="keterangan_admin" placeholder="Tambahkan catatan atau alasan status...">{{ $pengajuan->keterangan_admin }}</textarea>
                    <button class="mt-3 w-full rounded-lg bg-blue-600 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Simpan Status</button>
                </form>
            </aside>
        </div>
    </div>
@endsection
