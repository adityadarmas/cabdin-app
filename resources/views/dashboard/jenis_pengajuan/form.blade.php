@extends('layouts.app')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>.ql-toolbar.ql-snow{border-color:#e2e8f0;border-radius:.5rem .5rem 0 0;background:#f8fafc}.ql-container.ql-snow{border-color:#e2e8f0;border-radius:0 0 .5rem .5rem;font:inherit}.ql-editor{min-height:220px;line-height:1.75}.ql-editor.ql-blank::before{color:#94a3b8;font-style:normal}</style>
@endpush

@section('content')
    @php($savedFields = old('form_fields', json_encode($jenisPengajuan->form_fields ?? [])))
    <div class="max-w-3xl mx-auto">
        <a class="text-sm font-bold text-blue-600" href="{{ route('jenis-pengajuan.index') }}">← Jenis Pengajuan</a>
        <h1 class="mt-3 text-2xl font-extrabold text-slate-800">{{ $jenisPengajuan->exists ? 'Edit Jenis Pengumpulan Data' : 'Tambah Jenis Pengumpulan Data' }}</h1>
        <p class="mt-1 text-sm text-slate-500">Atur petunjuk dan template field yang dipakai ulang oleh operator.</p>

        <form id="jenis-form" class="mt-6 space-y-5" method="POST" action="{{ $jenisPengajuan->exists ? route('jenis-pengajuan.update', $jenisPengajuan) : route('jenis-pengajuan.store') }}">
            @csrf
            @if ($jenisPengajuan->exists) @method('PUT') @endif

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-extrabold text-slate-700">Informasi Jenis</h2>
                <label class="mt-5 block text-sm font-bold text-slate-700">Nama Jenis<input class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="nama" value="{{ old('nama', $jenisPengajuan->nama) }}" placeholder="Contoh: Pengumpulan Data Tambah PTK"></label>
                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                <label class="mt-5 block text-sm font-bold text-slate-700">Kategori Pengumpulan Data<select class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="kategori_pengajuan_id" required><option value="">Pilih kategori pengumpulan data</option>@foreach($kategoriPengajuans as $kategori)<option value="{{ $kategori->id }}" @selected(old('kategori_pengajuan_id', $jenisPengajuan->kategori_pengajuan_id) == $kategori->id)>{{ $kategori->nama }}</option>@endforeach</select><span class="mt-1 block text-xs font-normal text-slate-400">Kelola daftar kategori melalui menu Kategori Pengumpulan Data.</span></label>
                @error('kategori_pengajuan_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

                <div class="mt-5">
                    <label class="block text-sm font-bold text-slate-700">Petunjuk Pengisian</label>
                    <div id="quill-editor" class="mt-2"></div>
                    <textarea id="deskripsi-input" name="deskripsi" class="hidden">{{ old('deskripsi', $jenisPengajuan->deskripsi) }}</textarea>
                    <p class="mt-2 text-xs text-slate-400">Gunakan format teks, daftar, dan tombol tautan untuk menyisipkan link langsung di dalam petunjuk.</p>
                    @error('deskripsi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-bold text-slate-700">Urutan<input class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" min="1" type="number" name="urutan" value="{{ old('urutan', $jenisPengajuan->urutan ?? 1) }}"></label>
                    <label class="text-sm font-bold text-slate-700">Status Jenis<select class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="is_active"><option value="1" @selected(old('is_active', $jenisPengajuan->is_active ?? true) == 1)>Aktif</option><option value="0" @selected(old('is_active', $jenisPengajuan->is_active ?? true) == 0)>Nonaktif</option></select></label>
                </div>

                <div class="mt-5 rounded-xl border border-rose-100 bg-rose-50 p-4"><h3 class="text-sm font-extrabold text-rose-800">Tampilan Dashboard Tagihan</h3><p class="mt-1 text-xs leading-5 text-rose-700">Aktifkan bila jenis pengajuan ini perlu muncul sebagai card deadline pada dashboard operator.</p><div class="mt-4 grid gap-4 sm:grid-cols-2"><label class="text-sm font-bold text-slate-700">Tampilkan sebagai Tagihan<select class="mt-2 w-full rounded-lg border border-rose-200 bg-white px-3 py-2.5 font-normal" name="is_tagihan_dashboard"><option value="0" @selected(old('is_tagihan_dashboard', $jenisPengajuan->is_tagihan_dashboard ?? false) == 0)>Tidak</option><option value="1" @selected(old('is_tagihan_dashboard', $jenisPengajuan->is_tagihan_dashboard ?? false) == 1)>Ya, tampilkan</option></select></label><label class="text-sm font-bold text-slate-700">Deadline<input class="mt-2 w-full rounded-lg border border-rose-200 bg-white px-3 py-2.5 font-normal" type="datetime-local" name="deadline_at" value="{{ old('deadline_at', optional($jenisPengajuan->deadline_at)->format('Y-m-d\\TH:i')) }}"><span class="mt-1 block text-xs font-normal text-slate-500">Wajib diisi jika ditampilkan sebagai tagihan.</span></label></div></div>

                <div class="mt-5 border-t border-slate-100 pt-5"><h3 class="text-sm font-extrabold text-slate-700">Field Form Dasar</h3><p class="mt-1 text-xs leading-5 text-slate-500">Atur field standar yang ditampilkan kepada operator untuk jenis pengajuan ini.</p><div class="mt-4 grid gap-4 sm:grid-cols-2"><label class="rounded-xl border border-slate-200 p-4 text-sm font-bold text-slate-700">Keterangan<select class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="is_keterangan_enabled"><option value="1" @selected(old('is_keterangan_enabled', $jenisPengajuan->is_keterangan_enabled ?? true) == 1)>Aktif dan wajib diisi</option><option value="0" @selected(old('is_keterangan_enabled', $jenisPengajuan->is_keterangan_enabled ?? true) == 0)>Nonaktifkan field</option></select></label><label class="rounded-xl border border-slate-200 p-4 text-sm font-bold text-slate-700">Upload Lampiran<select class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 font-normal" name="is_lampiran_enabled"><option value="1" @selected(old('is_lampiran_enabled', $jenisPengajuan->is_lampiran_enabled ?? true) == 1)>Aktif</option><option value="0" @selected(old('is_lampiran_enabled', $jenisPengajuan->is_lampiran_enabled ?? true) == 0)>Nonaktifkan field</option></select></label></div></div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center justify-between"><div><h2 class="text-sm font-extrabold text-slate-700">Template Form Tambahan</h2><p class="mt-1 text-xs text-slate-500">Field ini akan muncul otomatis setelah operator memilih jenis pengajuan.</p></div><button id="add-field" type="button" class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600">+ Tambah Field</button></div><input id="form-fields" name="form_fields" type="hidden" value="{{ $savedFields }}"><div id="field-list" class="mt-5 space-y-3"></div><p id="empty-fields" class="mt-5 rounded-lg border border-dashed border-slate-300 p-4 text-center text-xs text-slate-400">Belum ada field tambahan. Template tetap dapat digunakan dengan form dasar.</p></section>
            <button class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-bold text-white hover:bg-blue-700">Simpan Template</button>
        </form>
    </div>

    <template id="field-template"><div class="field-item rounded-xl border border-slate-200 bg-slate-50 p-4"><div class="flex justify-between gap-3"><p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Field Tambahan</p><button type="button" class="remove-field text-xs font-bold text-red-600">Hapus</button></div><div class="mt-3 grid gap-3 sm:grid-cols-2"><input class="field-label rounded-lg border border-slate-200 px-3 py-2 text-sm" placeholder="Label, contoh: NIP PTK"><input class="field-key rounded-lg border border-slate-200 px-3 py-2 text-sm" placeholder="Kode, contoh: nip_ptk"></div><div class="mt-3 grid gap-3 sm:grid-cols-2"><select class="field-type rounded-lg border border-slate-200 px-3 py-2 text-sm"><option value="text">Teks singkat</option><option value="textarea">Teks panjang</option><option value="number">Angka</option><option value="date">Tanggal</option><option value="select">Pilihan</option></select><label class="flex items-center gap-2 text-sm text-slate-600"><input class="field-required" type="checkbox"> Wajib diisi</label></div><textarea class="field-options mt-3 hidden min-h-20 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" placeholder="Satu pilihan per baris"></textarea></div></template>
@endsection

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        const quill = new Quill('#quill-editor', { theme: 'snow', placeholder: 'Jelaskan data dan dokumen yang perlu disiapkan operator...', modules: { toolbar: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote', 'link'], ['clean']] } });
        const descriptionInput = document.getElementById('deskripsi-input');
        if (descriptionInput.value) quill.root.innerHTML = descriptionInput.value;
        document.getElementById('jenis-form').addEventListener('submit', () => descriptionInput.value = quill.root.innerHTML);

        const holder = document.getElementById('field-list'), dataInput = document.getElementById('form-fields'), empty = document.getElementById('empty-fields'), template = document.getElementById('field-template');
        function draw(field = {}) { const node = template.content.cloneNode(true), item = node.querySelector('.field-item'); item.querySelector('.field-label').value = field.label || ''; item.querySelector('.field-key').value = field.key || ''; item.querySelector('.field-type').value = field.type || 'text'; item.querySelector('.field-required').checked = !!field.required; item.querySelector('.field-options').value = (field.options || []).join('\n'); const toggle = () => item.querySelector('.field-options').classList.toggle('hidden', item.querySelector('.field-type').value !== 'select'); item.querySelector('.field-type').addEventListener('change', toggle); item.querySelector('.remove-field').addEventListener('click', () => { item.remove(); sync(); }); holder.appendChild(node); toggle(); sync(); }
        function sync() { const fields = [...holder.querySelectorAll('.field-item')].map(item => ({ label: item.querySelector('.field-label').value, key: item.querySelector('.field-key').value, type: item.querySelector('.field-type').value, required: item.querySelector('.field-required').checked, options: item.querySelector('.field-options').value })); dataInput.value = JSON.stringify(fields); empty.classList.toggle('hidden', fields.length > 0); }
        holder.addEventListener('input', sync); holder.addEventListener('change', sync); document.getElementById('add-field').addEventListener('click', () => draw()); try { JSON.parse(dataInput.value || '[]').forEach(draw); } catch (error) {} sync();
    </script>
@endpush
