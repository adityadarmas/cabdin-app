@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6"><a href="{{ route('operator.pengajuan.index') }}" class="text-sm font-semibold text-blue-600">← Pengumpulan Data Saya</a><h1 class="mt-3 text-2xl font-extrabold text-slate-800">{{ $pengajuan->exists ? 'Edit Pengumpulan Data' : 'Buat Pengumpulan Data' }}</h1><p class="mt-1 text-sm text-slate-500">Pilih jenis pengumpulan data terlebih dahulu untuk melihat petunjuk pengisiannya.</p></div>
    <form class="space-y-5" method="POST" enctype="multipart/form-data" action="{{ $pengajuan->exists ? route('operator.pengajuan.update',$pengajuan) : route('operator.pengajuan.store') }}">
        @csrf @if($pengajuan->exists) @method('PUT') @endif
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <label class="mb-2 block text-sm font-bold text-slate-700">Jenis Pengumpulan Data <span class="text-red-500">*</span></label>
            <select id="jenis-pengajuan" name="jenis_pengajuan_id" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Pilih jenis pengumpulan data</option>
                @foreach($jenisPengajuans->groupBy(fn($jenis) => $jenis->kategoriPengajuan?->nama ?? 'Lainnya') as $kategori => $jenisDalamKategori)<optgroup label="{{ $kategori }}">@foreach($jenisDalamKategori as $jenis)<option value="{{ $jenis->id }}" data-description="{{ $jenis->deskripsi }}" @selected(old('jenis_pengajuan_id',$pengajuan->jenis_pengajuan_id)==$jenis->id)>{{ $jenis->nama }}</option>@endforeach</optgroup>@endforeach
            </select>
            @error('jenis_pengajuan_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            <div id="petunjuk-jenis" class="mt-4 hidden rounded-xl border border-blue-100 bg-blue-50 p-4"><p class="text-xs font-extrabold uppercase tracking-wider text-blue-700">Petunjuk Pengisian</p><div id="petunjuk-text" class="mt-2 text-sm leading-6 text-blue-900 [&_a]:font-bold [&_a]:text-blue-700 [&_a]:underline [&_ol]:ml-5 [&_ol]:list-decimal [&_ul]:ml-5 [&_ul]:list-disc"></div></div>
        </div>
        @foreach($jenisPengajuans as $jenis)
        @if(!empty($jenis->form_fields))
        <section class="dynamic-fields hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-jenis="{{ $jenis->id }}">
            <h2 class="text-sm font-extrabold text-slate-700">Data Tambahan {{ $jenis->nama }}</h2><p class="mt-1 text-xs text-slate-500">Lengkapi data berikut sesuai jenis pengumpulan data yang dipilih.</p>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                @foreach($jenis->form_fields as $field)
                <div class="{{ $field['type'] === 'textarea' ? 'sm:col-span-2' : '' }}">
                    <label class="mb-2 block text-sm font-bold text-slate-700">{{ $field['label'] }} @if($field['required'])<span class="text-red-500">*</span>@endif</label>
                    @php($value = old('data_tambahan.'.$field['key'], $pengajuan->data_tambahan[$field['key']] ?? ''))
                    @if($field['type'] === 'textarea')<textarea disabled data-dynamic-input name="data_tambahan[{{ $field['key'] }}]" class="min-h-28 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm" placeholder="{{ $field['label'] }}">{{ $value }}</textarea>
                    @elseif($field['type'] === 'select')<select disabled data-dynamic-input name="data_tambahan[{{ $field['key'] }}]" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm"><option value="">Pilih {{ $field['label'] }}</option>@foreach($field['options'] ?? [] as $option)<option value="{{ $option }}" @selected($value===$option)>{{ $option }}</option>@endforeach</select>
                    @else<input disabled data-dynamic-input type="{{ $field['type'] }}" name="data_tambahan[{{ $field['key'] }}]" value="{{ $value }}" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm" placeholder="{{ $field['label'] }}">
                    @endif
                    @error('data_tambahan.'.$field['key'])<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                @endforeach
            </div>
        </section>
        @endif
        @endforeach
        @foreach($jenisPengajuans as $jenis)
            @if($jenis->is_keterangan_enabled)
                <div class="keterangan-fields hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-jenis="{{ $jenis->id }}"><label class="mb-2 block text-sm font-bold text-slate-700">Keterangan <span class="text-red-500">*</span></label><textarea disabled data-keterangan-input class="min-h-52 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm leading-7 focus:border-blue-500 focus:outline-none" name="isi" placeholder="Tuliskan keterangan pengumpulan data secara lengkap...">{{ old('isi',$pengajuan->isi) }}</textarea>@error('isi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            @endif
            @if($jenis->is_lampiran_enabled)
                <div class="lampiran-fields hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-jenis="{{ $jenis->id }}"><label class="mb-2 block text-sm font-bold text-slate-700">Lampiran <span class="font-normal text-slate-400">(opsional)</span></label><input disabled data-lampiran-input class="block w-full rounded-lg border border-dashed border-slate-300 p-3 text-sm text-slate-600" name="lampiran" type="file" accept="image/jpeg,image/png,image/webp,application/pdf"><p class="mt-2 text-xs text-slate-400">Format JPG, PNG, WEBP, atau PDF. Maksimal 5 MB.</p>@if($pengajuan->lampiran)<a target="_blank" class="mt-2 inline-block text-xs font-bold text-blue-600 hover:underline" href="{{ asset('storage/'.$pengajuan->lampiran) }}">Lihat lampiran saat ini</a>@endif @error('lampiran')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            @endif
        @endforeach
        <button class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-bold text-white hover:bg-blue-700">Kirim Pengumpulan Data</button><a class="ml-3 text-sm font-bold text-slate-500" href="{{ route('operator.pengajuan.index') }}">Batal</a>
    </form>
</div>
@push('scripts')
<script>
    const typeSelect=document.getElementById('jenis-pengajuan'), guide=document.getElementById('petunjuk-jenis'), guideText=document.getElementById('petunjuk-text');
    function updateGuide(){const option=typeSelect.options[typeSelect.selectedIndex], description=option?.dataset.description||'', id=typeSelect.value; guide.classList.toggle('hidden',!description); guideText.innerHTML=description; document.querySelectorAll('.dynamic-fields, .keterangan-fields, .lampiran-fields').forEach(section=>{const active=section.dataset.jenis===id;section.classList.toggle('hidden',!active);section.querySelectorAll('[data-dynamic-input], [data-keterangan-input], [data-lampiran-input]').forEach(input=>input.disabled=!active);});}
    typeSelect.addEventListener('change',updateGuide); updateGuide();
</script>
@endpush
@endsection
