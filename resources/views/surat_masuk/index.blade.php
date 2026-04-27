@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4 py-4 sm:py-6">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
        <h3 class="text-xl sm:text-2xl font-bold text-slate-800">
            @if(auth()->user()->role === 'pimpinan') 📨 Daftar Surat Masuk
            @elseif(auth()->user()->role === 'staff') 📬 Disposisi Surat Untuk Saya
            @else 📋 Kelola Surat Masuk
            @endif
        </h3>
        @can('create', \App\Models\SuratMasuk::class)
            <a href="{{ route('surat-masuk.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 transition">
                + Tambah Surat Masuk
            </a>
        @endcan
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-300 text-green-700 rounded-lg text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-300 text-red-700 rounded-lg text-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('surat-masuk.index') }}" class="mb-5">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari perihal, nomor surat, atau nama pengirim..."
                   class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm
                          focus:outline-none focus:ring-2 focus:ring-sky-400 bg-white">
            <button type="submit"
                    class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition text-sm font-medium">
                🔍 Cari
            </button>
            @if(request('search'))
                <a href="{{ route('surat-masuk.index') }}"
                   class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition text-sm">✕</a>
            @endif
        </div>
    </form>

    @php
        $statusMap = [
            'diterima'     => ['label' => 'Diterima',     'class' => 'bg-blue-100 text-blue-700'],
            'dikirim'      => ['label' => 'Dikirim',      'class' => 'bg-yellow-100 text-yellow-700'],
            'disetujui'    => ['label' => 'Disetujui',    'class' => 'bg-purple-100 text-purple-700'],
            'siap_diambil' => ['label' => 'Siap Diambil', 'class' => 'bg-green-100 text-green-700'],
            'disposisi'    => ['label' => 'Disposisi',    'class' => 'bg-teal-100 text-teal-700'],
        ];
    @endphp

    {{-- ============================================================
         PIMPINAN: CARD (mobile) + TABLE (desktop)
         ============================================================ --}}
    @if(auth()->user()->role === 'pimpinan')

        {{-- Mobile --}}
        <div class="md:hidden space-y-3">
            @forelse ($suratMasuk as $surat)
                @php $st = $statusMap[$surat->status] ?? ['label' => ucfirst($surat->status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <p class="font-semibold text-slate-800 text-sm leading-snug">
                            {{ $surat->perihal ?: '(Tanpa perihal)' }}
                        </p>
                        <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $st['class'] }}">
                            {{ $st['label'] }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mb-0.5">{{ $surat->nomor_surat }}</p>
                    <p class="text-xs text-slate-500 mb-2">{{ $surat->asal ?: ($surat->tamu->nama ?? '-') }}</p>
                    @if($surat->penerima && $surat->penerima->count() > 0)
                        <p class="text-xs text-green-600 mb-3">✓ Terdisposisi ke {{ $surat->penerima->count() }} staff</p>
                    @else
                        <p class="text-xs text-slate-400 italic mb-3">Belum terdisposisi</p>
                    @endif
                    <div class="flex flex-wrap gap-2">
                        @if($surat->status === 'dikirim' && !$surat->is_disposisi)
                            <form action="{{ route('surat-masuk.setujui', $surat) }}" method="POST"
                                  onsubmit="return confirm('Setujui surat ini?')">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-md bg-purple-500 text-white hover:bg-purple-600 transition text-xs font-medium">
                                    ✔️ Setujui
                                </button>
                            </form>
                        @endif
                        @can('update', $surat)
                            <a href="{{ route('surat-masuk.show', $surat) }}"
                               class="px-3 py-1.5 rounded-md text-white text-xs font-medium transition
                                      {{ $surat->is_disposisi ? 'bg-sky-500 hover:bg-sky-600' : 'bg-amber-500 hover:bg-amber-600' }}">
                                {{ $surat->is_disposisi ? '📤 Disposisi' : '📋 Detail' }}
                            </a>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-500 bg-white rounded-xl border border-slate-200">
                    <div class="text-4xl mb-2">📭</div>
                    <p class="font-medium">
                        {{ request('search') ? 'Tidak ada surat yang cocok dengan "' . request('search') . '"' : 'Belum ada data surat masuk' }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Desktop --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-10">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Perihal</th>
                        <th class="px-4 py-3 text-left font-semibold w-28">Asal</th>
                        <th class="px-4 py-3 text-left font-semibold w-32">Status</th>
                        <th class="px-4 py-3 text-left font-semibold w-36">Terdisposisi</th>
                        <th class="px-4 py-3 text-left font-semibold w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($suratMasuk as $surat)
                        @php $st = $statusMap[$surat->status] ?? ['label' => ucfirst($surat->status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500 text-xs">
                                {{ $loop->iteration + ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ Str::limit($surat->perihal, 50) ?: '(Tanpa perihal)' }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $surat->nomor_surat }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ Str::limit($surat->asal ?: ($surat->tamu->nama ?? '-'), 25) }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $st['class'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($surat->penerima && $surat->penerima->count() > 0)
                                    <span class="text-xs text-green-600 font-medium">✓ {{ $surat->penerima->count() }} staff</span>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1.5">
                                    @if($surat->status === 'dikirim' && !$surat->is_disposisi)
                                        <form action="{{ route('surat-masuk.setujui', $surat) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Setujui surat ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-md bg-purple-500 text-white hover:bg-purple-600 transition text-xs">
                                                ✔️ Setujui
                                            </button>
                                        </form>
                                    @endif
                                    @can('update', $surat)
                                        <a href="{{ route('surat-masuk.show', $surat) }}"
                                            class="px-3 py-1.5 rounded-md text-white text-xs transition
                                                   {{ $surat->is_disposisi ? 'bg-sky-500 hover:bg-sky-600' : 'bg-amber-500 hover:bg-amber-600' }}">
                                            {{ $surat->is_disposisi ? '📤 Disposisi' : '📋 Detail' }}
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-4xl">📭</span>
                                    <p class="font-medium">
                                        {{ request('search') ? 'Tidak ada surat yang cocok dengan "' . request('search') . '"' : 'Belum ada data surat masuk' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    {{-- ============================================================
         TU & STAFF: CARD (mobile) + TABLE (desktop)
         ============================================================ --}}
    @else

        {{-- Mobile --}}
        <div class="md:hidden space-y-3">
            @forelse ($suratMasuk as $surat)
                @php $st = $statusMap[$surat->status] ?? ['label' => ucfirst($surat->status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <p class="font-semibold text-slate-800 text-sm leading-snug">
                            {{ $surat->perihal ?: '(Tanpa perihal)' }}
                        </p>
                        @if(auth()->user()->role === 'staff')
                            @php
                                $pd = $surat->penerima->where('id', auth()->id())->first();
                                $ss = $pd ? $pd->pivot->status : 'pending';
                            @endphp
                            @if($ss === 'pending')
                                <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">⏳ Baru</span>
                            @elseif($ss === 'dibaca')
                                <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">👁️ Dibaca</span>
                            @else
                                <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">✅ Selesai</span>
                            @endif
                        @else
                            <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $st['class'] }}">
                                {{ $st['label'] }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400 mb-0.5">{{ $surat->nomor_surat }}</p>
                    <p class="text-xs text-slate-500 mb-3">{{ $surat->asal ?: ($surat->tamu->nama ?? '-') }}</p>

                    <div class="flex flex-wrap gap-2">
                        @if(auth()->user()->role === 'tu' && $surat->status === 'diterima')
                            <form action="{{ route('surat-masuk.kirim', $surat) }}" method="POST"
                                  onsubmit="return confirm('Kirim surat ini ke pimpinan?')">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition text-xs font-medium">
                                    📨 Kirim
                                </button>
                            </form>
                        @endif
                        @if(auth()->user()->role === 'tu' && $surat->status === 'disetujui')
                            <button type="button"
                                onclick="openSelesaiModal({{ $surat->id }}, '{{ route('surat-masuk.selesai', $surat) }}')"
                                class="px-3 py-1.5 rounded-md bg-green-600 text-white hover:bg-green-700 transition text-xs font-medium">
                                ✅ Selesai
                            </button>
                        @endif
                        @can('update', $surat)
                            <a href="{{ route('surat-masuk.show', $surat) }}"
                               class="px-3 py-1.5 rounded-md bg-amber-500 text-white hover:bg-amber-600 transition text-xs font-medium">
                                📋 Detail
                            </a>
                        @endcan
                        @if(auth()->user()->role === 'tu')
                            <a href="{{ route('surat-masuk.kitir', $surat) }}"
                               class="px-3 py-1.5 rounded-md bg-indigo-500 text-white hover:bg-indigo-600 transition text-xs">
                                🏷️ Kitir
                            </a>
                            <a href="{{ route('surat-masuk.tanda-terima', $surat) }}" target="_blank"
                               class="px-3 py-1.5 rounded-md bg-teal-600 text-white hover:bg-teal-700 transition text-xs">
                                📄 Tanda Terima
                            </a>
                            @if($surat->is_disposisi && $surat->penerima->count() > 0)
                                <a href="{{ route('surat-masuk.disposisi-cetak', $surat) }}"
                                   class="px-3 py-1.5 rounded-md bg-rose-500 text-white hover:bg-rose-600 transition text-xs">
                                    🖨️ Disposisi
                                </a>
                            @endif
                            @if($surat->tracking_url)
                                <a href="{{ $surat->tracking_url }}" target="_blank"
                                   class="px-3 py-1.5 rounded-md bg-cyan-500 text-white hover:bg-cyan-600 transition text-xs">
                                    🔗 Tracking
                                </a>
                            @endif
                        @endif
                        @can('delete', $surat)
                            <form action="{{ route('surat-masuk.destroy', $surat) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 transition text-xs">
                                    🗑️ Hapus
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-500 bg-white rounded-xl border border-slate-200">
                    <div class="text-4xl mb-2">📭</div>
                    <p class="font-medium">
                        @if(request('search'))
                            Tidak ada surat yang cocok dengan "{{ request('search') }}"
                        @elseif(auth()->user()->role === 'staff')
                            Belum ada disposisi surat untuk Anda
                        @else
                            Belum ada data surat masuk
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Desktop --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-10">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Perihal</th>
                        <th class="px-4 py-3 text-left font-semibold w-28">Asal</th>
                        @if(auth()->user()->role === 'staff')
                            <th class="px-4 py-3 text-left font-semibold w-28">Status</th>
                        @endif
                        @if(auth()->user()->role === 'tu')
                            <th class="px-4 py-3 text-left font-semibold w-32">Status</th>
                            <th class="px-4 py-3 text-left font-semibold w-40">Riwayat</th>
                            <th class="px-4 py-3 text-left font-semibold w-32">Pengambil</th>
                        @endif
                        <th class="px-4 py-3 text-left font-semibold w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($suratMasuk as $surat)
                        @php $st = $statusMap[$surat->status] ?? ['label' => ucfirst($surat->status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500 text-xs">
                                {{ $loop->iteration + ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ Str::limit($surat->perihal, 50) ?: '(Tanpa perihal)' }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $surat->nomor_surat }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ Str::limit($surat->asal ?: ($surat->tamu->nama ?? '-'), 25) }}
                            </td>

                            @if(auth()->user()->role === 'staff')
                                <td class="px-4 py-3">
                                    @php
                                        $pd = $surat->penerima->where('id', auth()->id())->first();
                                        $ss = $pd ? $pd->pivot->status : 'pending';
                                    @endphp
                                    @if($ss === 'pending')
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">⏳ Baru</span>
                                    @elseif($ss === 'dibaca')
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">👁️ Dibaca</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">✅ Selesai</span>
                                    @endif
                                </td>
                            @endif

                            @if(auth()->user()->role === 'tu')
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $st['class'] }}">
                                        {{ $st['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="space-y-0.5 text-xs text-slate-600">
                                        @if($surat->tgl_diterima)
                                            <div><span class="font-medium text-blue-600">Diterima:</span> {{ $surat->tgl_diterima->format('d/m/Y') }}</div>
                                        @endif
                                        @if($surat->tgl_dikirim)
                                            <div><span class="font-medium text-yellow-600">Dikirim:</span> {{ $surat->tgl_dikirim->format('d/m/Y') }}</div>
                                        @endif
                                        @if($surat->tgl_disetujui)
                                            <div><span class="font-medium text-purple-600">Disetujui:</span> {{ $surat->tgl_disetujui->format('d/m/Y') }}</div>
                                        @endif
                                        @if($surat->tgl_siap_diambil)
                                            <div><span class="font-medium text-green-600">Siap Diambil:</span> {{ $surat->tgl_siap_diambil->format('d/m/Y') }}</div>
                                        @endif
                                        @if(!$surat->tgl_diterima && !$surat->tgl_dikirim && !$surat->tgl_disetujui && !$surat->tgl_siap_diambil)
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-slate-700 text-xs">{{ $surat->nama_pengambil ?? '-' }}</td>
                            @endif

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1.5 items-center">
                                    {{-- Primary status action --}}
                                    @if(auth()->user()->role === 'tu' && $surat->status === 'diterima')
                                        <form action="{{ route('surat-masuk.kirim', $surat) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Kirim surat ini ke pimpinan?')">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition text-xs">
                                                📨 Kirim
                                            </button>
                                        </form>
                                    @elseif(auth()->user()->role === 'tu' && $surat->status === 'disetujui')
                                        <button type="button"
                                            onclick="openSelesaiModal({{ $surat->id }}, '{{ route('surat-masuk.selesai', $surat) }}')"
                                            class="px-3 py-1.5 rounded-md bg-green-600 text-white hover:bg-green-700 transition text-xs">
                                            ✅ Selesai
                                        </button>
                                    @endif

                                    {{-- Detail --}}
                                    @can('update', $surat)
                                        <a href="{{ route('surat-masuk.show', $surat) }}"
                                            class="px-3 py-1.5 rounded-md text-white text-xs transition bg-amber-500 hover:bg-amber-600">
                                            📋 Detail
                                        </a>
                                    @endcan

                                    {{-- TU: secondary actions in dropdown --}}
                                    @if(auth()->user()->role === 'tu')
                                        <div class="relative" data-dropdown>
                                            <button type="button" onclick="toggleDropdown(this)"
                                                class="px-2.5 py-1.5 rounded-md bg-slate-100 text-slate-600 hover:bg-slate-200 transition text-sm font-bold leading-none">
                                                ⋯
                                            </button>
                                            <div class="dropdown-menu hidden absolute right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg z-20 w-44 py-1">
                                                <a href="{{ route('surat-masuk.kitir', $surat) }}"
                                                   class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50">
                                                    🏷️ Kitir
                                                </a>
                                                <a href="{{ route('surat-masuk.tanda-terima', $surat) }}" target="_blank"
                                                   class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50">
                                                    📄 Tanda Terima
                                                </a>
                                                @if($surat->is_disposisi && $surat->penerima->count() > 0)
                                                    <a href="{{ route('surat-masuk.disposisi-cetak', $surat) }}"
                                                       class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50">
                                                        🖨️ Cetak Disposisi
                                                    </a>
                                                @endif
                                                @if($surat->tracking_url)
                                                    <a href="{{ $surat->tracking_url }}" target="_blank"
                                                       class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50">
                                                        🔗 Tracking
                                                    </a>
                                                @endif
                                                @if($surat->tamu && $surat->tamu->nomor_hp)
                                                    @php
                                                        $hp = preg_replace('/\D/', '', $surat->tamu->nomor_hp);
                                                        if (str_starts_with($hp, '0')) $hp = '62' . substr($hp, 1);
                                                        $trackingInfo = $surat->tracking_url ? "\nCek status surat: " . $surat->tracking_url : '';
                                                        $allDisposisiSelesai = $surat->status === 'disposisi'
                                                            && $surat->penerima->count() > 0
                                                            && $surat->penerima->every(fn($p) => $p->pivot->status === 'selesai');

                                                        if ($surat->status === 'siap_diambil') {
                                                            $pesan = urlencode(
                                                                "Yth. {$surat->tamu->nama},\n\n" .
                                                                "Kami informasikan bahwa surat Anda dengan:\n" .
                                                                "No. Surat : *{$surat->nomor_surat}*\n" .
                                                                "Perihal   : *{$surat->perihal}*\n\n" .
                                                                "✅ *Telah selesai diproses dan siap untuk diambil.*\n" .
                                                                "Silakan datang ke kantor kami untuk mengambil surat.\n" .
                                                                $trackingInfo . "\n\nTerima kasih.\nCabang Dinas Pendidikan Kab. Malang"
                                                            );
                                                        } elseif ($surat->status === 'disetujui') {
                                                            $pesan = urlencode(
                                                                "Yth. {$surat->tamu->nama},\n\n" .
                                                                "Kami informasikan bahwa surat Anda dengan:\n" .
                                                                "No. Surat : *{$surat->nomor_surat}*\n" .
                                                                "Perihal   : *{$surat->perihal}*\n\n" .
                                                                "✅ *Telah disetujui oleh pimpinan.*\n" .
                                                                "Surat Anda sedang disiapkan untuk pengambilan.\n" .
                                                                $trackingInfo . "\n\nTerima kasih.\nCabang Dinas Pendidikan Kab. Malang"
                                                            );
                                                        } elseif ($allDisposisiSelesai) {
                                                            $pesan = urlencode(
                                                                "Yth. {$surat->tamu->nama},\n\n" .
                                                                "Kami informasikan bahwa surat Anda dengan:\n" .
                                                                "No. Surat : *{$surat->nomor_surat}*\n" .
                                                                "Perihal   : *{$surat->perihal}*\n\n" .
                                                                "✅ *Telah selesai diproses oleh seluruh tim.*\n" .
                                                                $trackingInfo . "\n\nTerima kasih.\nCabang Dinas Pendidikan Kab. Malang"
                                                            );
                                                        } else {
                                                            $statusLabel = [
                                                                'diterima'  => 'Diterima dan sedang diproses',
                                                                'dikirim'   => 'Sedang diproses oleh pimpinan',
                                                                'disposisi' => 'Sedang diproses oleh tim',
                                                            ][$surat->status] ?? ucfirst($surat->status);
                                                            $pesan = urlencode(
                                                                "Yth. {$surat->tamu->nama},\n\n" .
                                                                "Surat Anda dengan:\n" .
                                                                "No. Surat : *{$surat->nomor_surat}*\n" .
                                                                "Perihal   : *{$surat->perihal}*\n" .
                                                                "Diterima  : " . \Carbon\Carbon::parse($surat->tgl_diterima)->translatedFormat('d F Y') . "\n\n" .
                                                                "Status: *{$statusLabel}*\n" .
                                                                $trackingInfo . "\n\nTerima kasih.\nCabang Dinas Pendidikan Kab. Malang"
                                                            );
                                                        }
                                                    @endphp
                                                    <a href="https://wa.me/{{ $hp }}?text={{ $pesan }}" target="_blank"
                                                       class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50">
                                                        💬 Kirim WA
                                                    </a>
                                                @endif
                                                @can('delete', $surat)
                                                    <div class="border-t border-slate-100 mt-1 pt-1">
                                                        <form action="{{ route('surat-masuk.destroy', $surat) }}" method="POST"
                                                              onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="flex items-center gap-2 w-full px-3 py-2 text-xs text-red-600 hover:bg-red-50">
                                                                🗑️ Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </div>
                                        </div>
                                    @else
                                        @can('delete', $surat)
                                            <form action="{{ route('surat-masuk.destroy', $surat) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus surat ini?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 transition text-xs">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-4xl">📭</span>
                                    <p class="font-medium">
                                        @if(request('search'))
                                            Tidak ada surat yang cocok dengan "{{ request('search') }}"
                                        @elseif(auth()->user()->role === 'staff')
                                            Belum ada disposisi surat untuk Anda
                                        @else
                                            Belum ada data surat masuk
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- PAGINATION --}}
    @if($suratMasuk->hasPages())
        <div class="mt-4 sm:mt-6">
            {{ $suratMasuk->links() }}
        </div>
    @endif

</div>

{{-- MODAL SELESAI --}}
@if(auth()->user()->role === 'tu')
    <div id="modal-selesai" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
            <h5 class="text-lg font-semibold text-slate-800 mb-1">✅ Selesai — Siap Diambil</h5>
            <p class="text-sm text-slate-500 mb-4">Masukkan nama orang yang mengambil surat ini.</p>
            <form id="form-selesai" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Nama Pengambil <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_pengambil" id="input-nama-pengambil"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                        placeholder="Nama lengkap pengambil surat" required>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeSelesaiModal()"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openSelesaiModal(id, actionUrl) {
            document.getElementById('form-selesai').action = actionUrl;
            document.getElementById('input-nama-pengambil').value = '';
            document.getElementById('modal-selesai').classList.remove('hidden');
            document.getElementById('input-nama-pengambil').focus();
        }
        function closeSelesaiModal() {
            document.getElementById('modal-selesai').classList.add('hidden');
        }
        document.getElementById('modal-selesai').addEventListener('click', function(e) {
            if (e.target === this) closeSelesaiModal();
        });

        function toggleDropdown(btn) {
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[data-dropdown]')) {
                document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.add('hidden'));
            }
        });
    </script>
    @endpush
@endif

@endsection
