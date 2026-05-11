@extends('layouts.app')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        border-radius: 8px 8px 0 0;
        border-color: #e2e8f0;
        background: #f8fafc;
        font-family: inherit;
    }
    .ql-container.ql-snow {
        border-radius: 0 0 8px 8px;
        border-color: #e2e8f0;
        font-family: inherit;
        font-size: 15px;
    }
    .ql-editor { min-height: 320px; line-height: 1.8; }
    .ql-editor p { margin-bottom: 0.75em; }
    .ql-editor.ql-blank::before { color: #94a3b8; font-style: normal; }
    .form-section {
        background: white; border: 1px solid #e2e8f0;
        border-radius: 12px; padding: 24px; margin-bottom: 20px;
    }
    .form-section-title {
        font-size: 13px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #64748b; margin-bottom: 16px;
        padding-bottom: 10px; border-bottom: 1px solid #f1f5f9;
    }
    .field-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .field-hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }
    .field-error { font-size: 12px; color: #ef4444; margin-top: 4px; }
    .form-input {
        width: 100%; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 10px 14px; font-size: 14px; font-family: inherit;
        color: #1e293b; transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
    .form-input.is-error { border-color: #ef4444; }
    .form-select {
        width: 100%; max-width: 240px; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 10px 14px; font-size: 14px; font-family: inherit;
        color: #1e293b; background: white; cursor: pointer; outline: none;
        transition: border-color .2s;
    }
    .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        background: #1e40af; color: white; font-size: 14px; font-weight: 600;
        padding: 10px 24px; border-radius: 8px; border: none; cursor: pointer;
        transition: background .2s, transform .15s;
    }
    .btn-submit:hover { background: #1d4ed8; transform: translateY(-1px); }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px;
        background: white; color: #64748b; font-size: 14px; font-weight: 600;
        padding: 10px 24px; border-radius: 8px;
        border: 1.5px solid #e2e8f0; transition: border-color .2s, color .2s;
    }
    .btn-cancel:hover { border-color: #94a3b8; color: #374151; }
    .thumb-current {
        border-radius: 8px; border: 1px solid #e2e8f0; display: block;
        max-height: 180px; object-fit: cover; margin-bottom: 12px;
    }
    .thumb-preview {
        width: 100%; max-height: 200px; object-fit: cover;
        border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 8px; display: none;
    }
    .upload-area {
        border: 2px dashed #e2e8f0; border-radius: 8px; padding: 16px;
        text-align: center; cursor: pointer; transition: border-color .2s, background .2s;
    }
    .upload-area:hover { border-color: #3b82f6; background: #eff6ff; }
    .upload-area input[type="file"] { display: none; }
    .upload-icon { color: #94a3b8; margin: 0 auto 6px; }
    .upload-text { font-size: 13px; color: #64748b; }
    .upload-hint { font-size: 11px; color: #94a3b8; margin-top: 3px; }
    .char-count { font-size: 12px; color: #94a3b8; text-align: right; margin-top: 4px; }
    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 100px;
    }
    .status-aktif { background: #dcfce7; color: #16a34a; }
    .status-nonaktif { background: #fee2e2; color: #dc2626; }
</style>
@endpush

@section('content')
<div class="max-w-3xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('berita.index') }}" class="text-slate-400 hover:text-slate-600">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-800">Edit Berita</h1>
            <p class="text-sm text-slate-500 mt-0.5">Perbarui konten artikel berita</p>
        </div>
        <span class="ml-auto status-badge {{ $berita->is_active ? 'status-aktif' : 'status-nonaktif' }}">
            <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
            {{ $berita->is_active ? 'Aktif' : 'Nonaktif' }}
        </span>
    </div>

    <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data" id="berita-form">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="form-section">
            <div class="form-section-title">Informasi Artikel</div>

            <div class="mb-4">
                <label class="field-label">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul-input"
                       class="form-input {{ $errors->has('judul') ? 'is-error' : '' }}"
                       value="{{ old('judul', $berita->judul) }}"
                       placeholder="Tulis judul berita yang menarik..."
                       maxlength="255">
                <div class="char-count"><span id="judul-count">0</span>/255</div>
                @error('judul')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-4 flex-wrap">
                <div class="flex-1" style="min-width:180px;">
                    <label class="field-label">Tanggal Publikasi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal"
                           class="form-input {{ $errors->has('tanggal') ? 'is-error' : '' }}"
                           value="{{ old('tanggal', \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d')) }}"
                           style="max-width: 220px;">
                    @error('tanggal')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="field-label">Status Publikasi</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $berita->is_active) == '1' ? 'selected' : '' }}>Aktif (Tampil publik)</option>
                        <option value="0" {{ old('is_active', $berita->is_active) == '0' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                    </select>
                    @error('is_active')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Konten --}}
        <div class="form-section">
            <div class="form-section-title">Isi Konten</div>
            <label class="field-label">Konten Berita <span class="text-red-500">*</span></label>
            <div id="quill-editor"></div>
            <textarea name="konten" id="konten-input" style="display:none;">{{ old('konten', $berita->konten) }}</textarea>
            <div class="field-hint">Gunakan toolbar untuk memformat teks: heading, tebal, miring, daftar, kutipan, dan tautan.</div>
            @error('konten')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Thumbnail --}}
        <div class="form-section">
            <div class="form-section-title">Gambar Thumbnail</div>
            <label class="field-label">Foto Sampul</label>

            @if($berita->thumbnail)
            <div class="mb-3">
                <p class="text-xs text-slate-400 mb-2">Thumbnail saat ini:</p>
                <img src="{{ asset('storage/' . $berita->thumbnail) }}" class="thumb-current" style="max-width:280px;">
            </div>
            <p class="text-xs text-slate-500 mb-3">Upload gambar baru untuk mengganti thumbnail di atas:</p>
            @endif

            <div class="upload-area" onclick="document.getElementById('thumbnail-input').click()">
                <input type="file" name="thumbnail" id="thumbnail-input"
                       accept="image/jpeg,image/png,image/jpg,image/gif"
                       onchange="previewThumb(this)">
                <div class="upload-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="upload-text">Klik untuk pilih gambar baru</div>
                <div class="upload-hint">JPG, PNG, GIF · Maks. 2 MB · Rekomendasi 1200×630 px</div>
            </div>
            <img id="thumb-preview" class="thumb-preview" alt="Preview">
            @error('thumbnail')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pb-8">
            <button type="submit" class="btn-submit">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('berita.index') }}" class="btn-cancel">Batal</a>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['blockquote', 'link'],
                ['clean']
            ]
        }
    });

    // Pre-fill with existing content
    var existingContent = document.getElementById('konten-input').value;
    if (existingContent) quill.root.innerHTML = existingContent;

    // Sync to hidden textarea on submit
    document.getElementById('berita-form').addEventListener('submit', function () {
        document.getElementById('konten-input').value = quill.root.innerHTML;
    });

    // Judul character counter
    var judulInput = document.getElementById('judul-input');
    var judulCount = document.getElementById('judul-count');
    function updateCount() { judulCount.textContent = judulInput.value.length; }
    judulInput.addEventListener('input', updateCount);
    updateCount();

    // Thumbnail preview
    function previewThumb(input) {
        var preview = document.getElementById('thumb-preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
