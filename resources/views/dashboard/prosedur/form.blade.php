@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .procedure-form { max-width: 900px; }
    .procedure-section { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:24px; margin-bottom:20px; }
    .procedure-section-title { font-size:12px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:#64748b; border-bottom:1px solid #f1f5f9; padding-bottom:12px; margin-bottom:18px; }
    .procedure-label { display:block; font-size:14px; font-weight:700; color:#334155; margin-bottom:7px; }
    .procedure-hint,.procedure-error { font-size:12px; margin-top:5px; }.procedure-hint{color:#94a3b8}.procedure-error{color:#dc2626}
    .procedure-input { width:100%; padding:10px 13px; border:1px solid #dbe2ea; border-radius:8px; font:inherit; color:#1e293b; outline:none; transition:.2s; }
    .procedure-input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.12); }.procedure-input.is-error{border-color:#ef4444}
    .procedure-grid { display:grid; grid-template-columns:2fr 1fr 1fr; gap:16px; }.ql-toolbar.ql-snow{border-color:#dbe2ea;border-radius:8px 8px 0 0;background:#f8fafc}.ql-container.ql-snow{border-color:#dbe2ea;border-radius:0 0 8px 8px;font:inherit;font-size:15px}.ql-editor{min-height:330px;line-height:1.8}.upload-box{border:2px dashed #dbe2ea;border-radius:10px;padding:22px;text-align:center;cursor:pointer;transition:.2s}.upload-box:hover{border-color:#3b82f6;background:#eff6ff}.upload-box input{display:none}.preview{display:none;width:100%;max-height:250px;object-fit:cover;border-radius:10px;margin-top:12px;border:1px solid #e2e8f0}.btn-save{background:#1d4ed8;color:#fff;border:0;border-radius:8px;padding:11px 20px;font-weight:700;cursor:pointer}.btn-save:hover{background:#1e40af}.btn-cancel{margin-left:10px;padding:10px 18px;border:1px solid #dbe2ea;border-radius:8px;color:#64748b;font-weight:700}@media(max-width:700px){.procedure-grid{grid-template-columns:1fr}}
</style>
@endpush

<div class="procedure-form">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('prosedur.index') }}" class="text-slate-400 hover:text-slate-600">←</a><div><h1 class="text-xl font-bold text-slate-800">{{ $pageTitle }}</h1><p class="text-sm text-slate-500 mt-0.5">{{ $pageDescription }}</p></div></div>
    <form id="prosedur-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <section class="procedure-section"><div class="procedure-section-title">Informasi Dasar</div><div class="mb-4"><label class="procedure-label">Judul Prosedur <span class="text-red-500">*</span></label><input id="judul-input" class="procedure-input @error('judul') is-error @enderror" name="judul" maxlength="255" value="{{ old('judul', $prosedur?->judul) }}" placeholder="Contoh: Pengajuan Mutasi Peserta Didik"><div class="procedure-hint"><span id="title-count">0</span>/255 karakter</div>@error('judul')<div class="procedure-error">{{ $message }}</div>@enderror</div><div class="procedure-grid"><div><label class="procedure-label">Kategori <span class="text-red-500">*</span></label><select name="kategori_id" class="procedure-input @error('kategori_id') is-error @enderror"><option value="">Pilih kategori</option>@foreach($kategori as $kat)<option value="{{ $kat->id }}" @selected(old('kategori_id', $prosedur?->kategori_id) == $kat->id)>{{ $kat->nama }}</option>@endforeach</select>@error('kategori_id')<div class="procedure-error">{{ $message }}</div>@enderror</div><div><label class="procedure-label">Urutan Tampil</label><input class="procedure-input" type="number" min="1" name="urutan" value="{{ old('urutan', $prosedur?->urutan ?? 1) }}"></div><div><label class="procedure-label">Status</label><select name="is_active" class="procedure-input"><option value="1" @selected(old('is_active', $prosedur?->is_active ?? true) == 1)>Aktif</option><option value="0" @selected(old('is_active', $prosedur?->is_active ?? true) == 0)>Nonaktif</option></select></div></div></section>
        <section class="procedure-section"><div class="procedure-section-title">Panduan Prosedur</div><label class="procedure-label">Isi Prosedur <span class="text-red-500">*</span></label><div id="quill-editor"></div><textarea id="deskripsi-input" name="deskripsi" class="hidden">{{ old('deskripsi', $prosedur?->deskripsi) }}</textarea><p class="procedure-hint">Gunakan heading, daftar bernomor, daftar poin, kutipan, dan tautan agar langkah-langkah mudah dipahami.</p>@error('deskripsi')<div class="procedure-error">{{ $message }}</div>@enderror</section>
        <section class="procedure-section"><div class="procedure-section-title">Gambar Sampul</div><label class="procedure-label">Gambar Utama <span class="text-slate-400 font-normal">(opsional)</span></label><div class="upload-box" onclick="document.getElementById('thumbnail-input').click()"><input id="thumbnail-input" type="file" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp"><div class="text-slate-500 font-semibold">Klik untuk memilih gambar</div><div class="procedure-hint">JPG, PNG, atau WEBP · Maksimal 2 MB · Rekomendasi 1200 × 630 px</div></div><img id="preview" class="preview" alt="Pratinjau gambar" @if($prosedur?->thumbnail) src="{{ asset('storage/'.$prosedur->thumbnail) }}" style="display:block" @endif>@error('thumbnail')<div class="procedure-error">{{ $message }}</div>@enderror</section>
        <div class="pb-8"><button class="btn-save" type="submit">{{ $submitLabel }}</button><a class="btn-cancel" href="{{ route('prosedur.index') }}">Batal</a></div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    const quill = new Quill('#quill-editor', { theme:'snow', placeholder:'Tulis langkah-langkah prosedur di sini...', modules:{ toolbar:[[{'header':[2,3,false]}],['bold','italic','underline'],[{'list':'ordered'},{'list':'bullet'}],['blockquote','link'],['clean']] } });
    const contentInput = document.getElementById('deskripsi-input'); if (contentInput.value) quill.root.innerHTML = contentInput.value;
    document.getElementById('prosedur-form').addEventListener('submit', () => contentInput.value = quill.root.innerHTML);
    const title = document.getElementById('judul-input'), counter = document.getElementById('title-count'); const updateCount = () => counter.textContent = title.value.length; title.addEventListener('input', updateCount); updateCount();
    document.getElementById('thumbnail-input').addEventListener('change', function(){ if(!this.files[0]) return; const reader = new FileReader(); reader.onload = e => { const preview=document.getElementById('preview'); preview.src=e.target.result; preview.style.display='block'; }; reader.readAsDataURL(this.files[0]); });
</script>
@endpush
