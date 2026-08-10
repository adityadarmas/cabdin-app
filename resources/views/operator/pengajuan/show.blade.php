@extends('layouts.app')

@section('content')
    @php
        $statusStyle = [
            'menunggu' => 'bg-amber-100 text-amber-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'disetujui' => 'bg-emerald-100 text-emerald-700',
            'ditolak' => 'bg-red-100 text-red-700',
        ];
        $jenis = $pengajuan->jenisPengajuan;
        $fieldLabels = collect($jenis?->form_fields ?? [])->keyBy('key');
    @endphp

    <div class="max-w-4xl mx-auto">
        <a href="{{ $jenis ? route('operator.pengajuan.jenis', $jenis) : route('operator.pengajuan.index') }}" class="mb-5 inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600">← Kembali ke riwayat pengajuan</a>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="bg-gradient-to-r from-blue-700 to-blue-600 p-6 text-white">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-blue-100">Detail Pengajuan</p>
                        <h1 class="mt-2 text-2xl font-extrabold">{{ $jenis?->nama ?? $pengajuan->judul }}</h1>
                        <p class="mt-2 text-sm text-blue-100">Dikirim {{ $pengajuan->submitted_at?->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <span class="w-fit rounded-full px-3 py-1.5 text-xs font-extrabold {{ $statusStyle[$pengajuan->status] ?? 'bg-slate-100 text-slate-700' }}">{{ ucfirst($pengajuan->status) }}</span>
                </div>
            </div>

            <div class="space-y-6 p-6">
                @if (filled($pengajuan->isi))
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-700">Keterangan Pengajuan</h2>
                        <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-600">{{ $pengajuan->isi }}</p>
                    </div>
                @endif

                @if (!empty($pengajuan->data_tambahan))
                    <div class="border-t border-slate-100 pt-6">
                        <h2 class="text-sm font-extrabold text-slate-700">Data Tambahan</h2>
                        <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                            @foreach ($pengajuan->data_tambahan as $key => $value)
                                <div class="rounded-xl bg-slate-50 p-4">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ data_get($fieldLabels->get($key), 'label', str_replace('_', ' ', $key)) }}</dt>
                                    <dd class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-700">{{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif

                @if ($pengajuan->lampiran)
                    <div class="border-t border-slate-100 pt-6">
                        <h2 class="text-sm font-extrabold text-slate-700">Lampiran</h2>
                        <a target="_blank" href="{{ asset('storage/'.$pengajuan->lampiran) }}" class="mt-3 inline-flex rounded-lg bg-blue-50 px-4 py-2.5 text-sm font-bold text-blue-700 hover:bg-blue-100">Buka lampiran</a>
                    </div>
                @endif

                @if ($pengajuan->keterangan_admin)
                    <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
                        <h2 class="text-sm font-extrabold text-blue-800">Keterangan Admin</h2>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-blue-900">{{ $pengajuan->keterangan_admin }}</p>
                    </div>
                @endif

                @if (in_array($pengajuan->status, ['menunggu', 'ditolak']))
                    <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ route('operator.pengajuan.edit', $pengajuan) }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Edit Pengajuan</a>
                        <form method="POST" action="{{ route('operator.pengajuan.destroy', $pengajuan) }}" onsubmit="return confirm('Hapus pengajuan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-red-200 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50">Hapus</button>
                        </form>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
