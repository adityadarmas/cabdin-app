@extends('layouts.dashboard')

@section('content')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <div class="mx-auto max-w-3xl">
        <a class="text-sm font-bold text-blue-600" href="{{ route('panduan.index') }}">&larr; Panduan Operator</a>
        <h1 class="mt-3 text-2xl font-extrabold text-slate-800">{{ $panduan->exists ? 'Edit Panduan' : 'Tambah Panduan' }}</h1>
        <p class="mt-1 text-sm text-slate-500">Panduan ditampilkan sebagai artikel pada dashboard operator sekolah.</p>

        <form id="panduan-form" class="mt-6 space-y-5" method="POST" enctype="multipart/form-data" action="{{ $panduan->exists ? route('panduan.update', $panduan) : route('panduan.store') }}">
            @csrf
            @if($panduan->exists) @method('PUT') @endif

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <label class="block text-sm font-bold text-slate-700">Judul Panduan
                    <input class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="judul" value="{{ old('judul', $panduan->judul) }}" required>
                </label>
                @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <div class="mt-5">
                    <label class="block text-sm font-bold text-slate-700">Isi Artikel</label>
                    <div id="quill-editor" class="mt-2"></div>
                    <textarea id="konten-input" class="hidden" name="konten">{{ old('konten', $panduan->konten) }}</textarea>
                    <p class="mt-2 text-xs text-slate-400">Mendukung heading, format teks, daftar, kutipan, dan tautan.</p>
                    @error('konten') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-bold text-slate-700">Gambar <span class="font-normal text-slate-400">(opsional)</span>
                        <input class="mt-2 block w-full rounded-lg border border-dashed border-slate-300 p-3 text-sm font-normal" type="file" name="gambar" accept="image/jpeg,image/png,image/webp">
                    </label>
                    <label class="text-sm font-bold text-slate-700">Lampiran File <span class="font-normal text-slate-400">(opsional)</span>
                        <input class="mt-2 block w-full rounded-lg border border-dashed border-slate-300 p-3 text-sm font-normal" type="file" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                    </label>
                </div>
                <p class="mt-2 text-xs text-slate-400">Gambar maksimal 4 MB. Lampiran maksimal 10 MB.</p>
                @if($panduan->gambar)<a class="mt-2 inline-block text-xs font-bold text-blue-600" target="_blank" href="{{ asset('storage/'.$panduan->gambar) }}">Lihat gambar saat ini</a>@endif
                @if($panduan->lampiran)<a class="ml-3 mt-2 inline-block text-xs font-bold text-blue-600" target="_blank" href="{{ asset('storage/'.$panduan->lampiran) }}">Lihat lampiran saat ini</a>@endif

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-bold text-slate-700">Urutan
                        <input class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" type="number" min="1" name="urutan" value="{{ old('urutan', $panduan->urutan ?? 1) }}" required>
                    </label>
                    <label class="text-sm font-bold text-slate-700">Status
                        <select class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="is_active">
                            <option value="1" @selected(old('is_active', $panduan->is_active ?? true) == 1)>Aktif</option>
                            <option value="0" @selected(old('is_active', $panduan->is_active ?? true) == 0)>Nonaktif</option>
                        </select>
                    </label>
                </div>
            </section>
            <button class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-bold text-white hover:bg-blue-700">Simpan Panduan</button>
        </form>
    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        const quill = new Quill('#quill-editor', { theme: 'snow', modules: { toolbar: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote', 'link'], ['clean']] } });
        const kontenInput = document.getElementById('konten-input');
        if (kontenInput.value) quill.root.innerHTML = kontenInput.value;
        document.getElementById('panduan-form').addEventListener('submit', () => kontenInput.value = quill.root.innerHTML);
    </script>
@endsection
