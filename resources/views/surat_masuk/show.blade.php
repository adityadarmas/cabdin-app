@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="max-w-4xl mx-auto px-2 sm:px-4 py-4 sm:py-6">

        <a href="{{ route('surat-masuk.index') }}"
           class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 transition mb-4">
            ← Kembali
        </a>

        <!-- JUDUL -->
        <h4 class="text-xl sm:text-2xl font-bold text-slate-800 mb-4 sm:mb-6">
            Detail Surat Masuk
        </h4>

        <!-- DETAIL SURAT (responsive dl) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <dl class="divide-y divide-slate-200">

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Nomor Surat</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->nomor_surat }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Perihal</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->perihal }}</dd>
                </div>

                @if($suratMasuk->ringkasan)
                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Ringkasan</dt>
                    <dd class="text-sm sm:flex-1">
                        <div class="bg-sky-50 border border-sky-200 rounded-lg px-4 py-3 text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                            {{ $suratMasuk->ringkasan }}
                        </div>
                    </dd>
                </div>
                @endif

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Asal</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->asal }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Tanggal Diterima</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->tgl_diterima }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Sifat</dt>
                    <dd class="text-sm text-slate-800 capitalize">{{ $suratMasuk->sifat_dispo ?? '-' }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Jenis</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->jenis ?? '-' }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Dari (Tamu)</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->tamu->nama ?? '-' }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Harap Dilaksanakan</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->dengan_hormat_harap ?? '-' }}</dd>
                </div>

                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">Keterangan</dt>
                    <dd class="text-sm text-slate-800">{{ $suratMasuk->disposisi ?? '-' }}</dd>
                </div>

                {{-- FILE SURAT --}}
                <div class="px-4 py-3 sm:flex sm:gap-4">
                    <dt class="text-sm font-medium text-slate-600 sm:w-1/3 mb-1 sm:mb-0">File Surat</dt>
                    <dd class="text-sm text-slate-800">
                        @if ($suratMasuk->filepath)
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ asset('storage/' . $suratMasuk->filepath) }}" target="_blank"
                                    class="px-3 py-1.5 rounded-lg text-sm bg-sky-100 text-sky-700 hover:bg-sky-200 transition">
                                    📄 Buka PDF
                                </a>
                                <a href="{{ asset('storage/' . $suratMasuk->filepath) }}" download
                                    class="px-3 py-1.5 rounded-lg text-sm bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                    ⬇ Download
                                </a>
                            </div>
                        @else
                            <span class="italic text-slate-400">Tidak ada file</span>
                        @endif
                    </dd>
                </div>

            </dl>
        </div>

        {{-- LINK TRACKING (non-pimpinan) --}}
        @if(auth()->user()->role !== 'pimpinan')
            <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-6">
                <h5 class="text-base sm:text-lg font-semibold text-amber-800 mb-4">
                    🔗 Link Tracking untuk Tamu
                </h5>

                @if ($suratMasuk->tracking_token)
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 mb-3">
                        <input type="text" id="tracking-url" value="{{ $suratMasuk->tracking_url }}"
                            readonly
                            class="flex-1 px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm min-w-0">
                        <button onclick="copyTrackingUrl()"
                            class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition text-sm shrink-0">
                            📋 Copy
                        </button>
                    </div>
                    <p class="text-sm text-slate-600">
                        Bagikan link ini ke tamu. Berlaku hingga:
                        <strong>{{ $suratMasuk->token_expires_at->format('d/m/Y') }}</strong>
                    </p>
                @else
                    <p class="text-slate-600 mb-3">Link tracking belum dibuat untuk surat ini.</p>
                    <form action="{{ route('surat-masuk.generate-token', $suratMasuk) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition text-sm">
                            Generate Link Tracking
                        </button>
                    </form>
                @endif
            </div>

            <script>
                function copyTrackingUrl() {
                    const input = document.getElementById('tracking-url');
                    input.select();
                    document.execCommand('copy');
                    alert('Link berhasil dicopy!');
                }
            </script>
        @endif

        {{-- PREVIEW PDF --}}
        @if ($suratMasuk->filepath && Str::endsWith($suratMasuk->filepath, '.pdf'))
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <h5 class="text-base font-semibold text-slate-700 mb-3">
                    Preview Surat (PDF)
                </h5>
                <iframe src="{{ asset('storage/' . $suratMasuk->filepath) }}"
                        class="w-full h-[350px] sm:h-[550px] md:h-[650px] border rounded-lg"
                        loading="lazy">
                </iframe>
            </div>
        @endif

        {{-- STAFF PENERIMA DISPOSISI --}}
        @if ($suratMasuk->penerima && $suratMasuk->penerima->count() > 0)
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6">
                <h5 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                    📋 Staff Penerima Disposisi
                </h5>

                {{-- Mobile: card list --}}
                <div class="sm:hidden space-y-2">
                    @foreach ($suratMasuk->penerima as $index => $penerima)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ $penerima->name }}</p>
                                <p class="text-xs text-slate-500">{{ $penerima->pivot->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                @if ($penerima->pivot->status == 'pending')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">⏳ Belum</span>
                                @elseif($penerima->pivot->status == 'dibaca')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">👁️ Dibaca</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">✅ Selesai</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop: tabel --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-slate-600">No</th>
                                <th class="px-4 py-3 text-left font-medium text-slate-600">Nama Staff</th>
                                <th class="px-4 py-3 text-left font-medium text-slate-600">Status</th>
                                <th class="px-4 py-3 text-left font-medium text-slate-600">Tanggal Diterima</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($suratMasuk->penerima as $index => $penerima)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-slate-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-slate-800 font-medium">{{ $penerima->name }}</td>
                                    <td class="px-4 py-3">
                                        @if ($penerima->pivot->status == 'pending')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                                ⏳ Belum Dibaca
                                            </span>
                                        @elseif($penerima->pivot->status == 'dibaca')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                👁️ Sudah Dibaca
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                ✅ Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        {{ $penerima->pivot->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($suratMasuk->disposisi)
                    <div class="mt-4 p-3 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600">
                            <strong class="text-slate-700">Catatan Disposisi:</strong>
                            {{ $suratMasuk->disposisi }}
                        </p>
                    </div>
                @endif
            </div>
        @endif

        {{-- TOMBOL SETUJUI (pimpinan, status=dikirim, non-disposisi) --}}
        @if(auth()->user()->role === 'pimpinan' && $suratMasuk->status === 'dikirim' && !$suratMasuk->is_disposisi)
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4 sm:p-5">
                <p class="font-semibold text-yellow-800 mb-1">Surat ini menunggu persetujuan Anda</p>
                <p class="text-sm text-yellow-700 mb-4">
                    Dikirim oleh TU pada
                    {{ $suratMasuk->tgl_dikirim ? $suratMasuk->tgl_dikirim->format('d/m/Y H:i') : '-' }}
                </p>
                <form action="{{ route('surat-masuk.setujui', $suratMasuk) }}" method="POST"
                      onsubmit="return confirm('Setujui surat ini?')">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition font-medium">
                        ✔️ Setujui Surat
                    </button>
                </form>
            </div>
        @endif

        {{-- FORM DISPOSISI (pimpinan, surat disposisi) --}}
        @if($suratMasuk->is_disposisi)
        @can('disposisi', $suratMasuk)
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6">

                <h5 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                    📤 Disposisi Surat
                </h5>

                <form method="POST" action="{{ route('surat-masuk.disposisi', $suratMasuk) }}"
                      enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- PILIH STAFF --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Tujuan (Staff) <span class="text-red-500">*</span>
                        </label>

                        <div class="border border-slate-300 rounded-lg p-4 max-h-60 overflow-y-auto bg-slate-50">
                            <label class="flex items-center gap-2 mb-3 pb-3 border-b border-slate-300">
                                <input type="checkbox" id="select-all"
                                    class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                <span class="text-sm font-semibold text-slate-800">✓ Pilih Semua Staff</span>
                            </label>

                            <div class="space-y-2">
                                @foreach ($staff as $user)
                                    <label class="flex items-center gap-3 hover:bg-white px-2 py-2 rounded transition cursor-pointer">
                                        <input type="checkbox" name="staff_ids[]" value="{{ $user->id }}"
                                            class="staff-checkbox rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                            {{ $suratMasuk->penerima && $suratMasuk->penerima->contains($user->id) ? 'checked' : '' }}>
                                        <span class="text-sm text-slate-700">{{ $user->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        @error('staff_ids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SIFAT DISPOSISI --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Sifat Disposisi
                        </label>
                        <div class="flex flex-wrap gap-x-6 gap-y-2">
                            @php
                                $sifatList = [
                                    'sangat_segera' => 'Sangat Segera',
                                    'segera'        => 'Segera',
                                    'rahasia'       => 'Rahasia',
                                ];
                            @endphp
                            @foreach ($sifatList as $value => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sifat_dispo" value="{{ $value }}"
                                        class="border-slate-300 text-sky-600 focus:ring-sky-500"
                                        {{ old('sifat_dispo', $suratMasuk->sifat_dispo ?? '') === $value ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- TANGGAL KEGIATAN --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Tanggal Kegiatan
                        </label>
                        <input type="date" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan', $suratMasuk->tgl_kegiatan) }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    {{-- DENGAN HORMAT HARAP --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Dengan Hormat Harap
                        </label>

                        @php
                            $pilihanList = [
                                'Tanggapan dan saran',
                                'Proses lebih lanjut',
                                'Koordinasikan / konfirmasikan',
                            ];
                            $harapSebelumnya = $suratMasuk->dengan_hormat_harap
                                ? explode(', ', explode(' | ', $suratMasuk->dengan_hormat_harap)[0])
                                : [];
                        @endphp

                        <div class="space-y-2 mb-3">
                            @foreach ($pilihanList as $item)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="harap_pilihan[]" value="{{ $item }}"
                                        class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                        {{ in_array($item, $harapSebelumnya) ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-700">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>

                        <textarea name="harap_keterangan" rows="2"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                            placeholder="Keterangan tambahan (opsional)...">{{ old('harap_keterangan') }}</textarea>
                    </div>

                    {{-- CATATAN DISPOSISI --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Catatan Disposisi
                        </label>
                        <textarea name="disposisi" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">{{ old('disposisi', $suratMasuk->disposisi) }}</textarea>
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-slate-200">
                        <a href="{{ route('surat-masuk.index') }}"
                            class="text-center px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700
                                  hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white
                                   px-5 py-2.5 rounded-lg transition font-medium">
                            💾 Simpan & Kirim Disposisi
                        </button>
                    </div>

                </form>
            </div>
        @endcan
        @endif

    </div>

    @push('scripts')
        <script>
            const selectAllCheckbox = document.getElementById('select-all');
            const staffCheckboxes = document.querySelectorAll('.staff-checkbox');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    staffCheckboxes.forEach(cb => cb.checked = this.checked);
                });

                staffCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked  = Array.from(staffCheckboxes).every(cb => cb.checked);
                        const someChecked = Array.from(staffCheckboxes).some(cb => cb.checked);
                        selectAllCheckbox.checked       = allChecked;
                        selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    });
                });

                const initialAllChecked  = Array.from(staffCheckboxes).every(cb => cb.checked);
                const initialSomeChecked = Array.from(staffCheckboxes).some(cb => cb.checked);
                selectAllCheckbox.checked       = initialAllChecked;
                selectAllCheckbox.indeterminate = initialSomeChecked && !initialAllChecked;
            }
        </script>
    @endpush
@endsection
