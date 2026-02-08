@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Tambah Berita</h3>

    <form action="{{ route('berita.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text"
                   name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul') }}">
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date"
                   name="tanggal"
                   class="form-control @error('tanggal') is-invalid @enderror"
                   value="{{ old('tanggal') }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea name="konten"
                      rows="5"
                      class="form-control @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
            @error('konten')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Thumbnail (Opsional)</label>
            <input type="file"
                   name="thumbnail"
                   class="form-control @error('thumbnail') is-invalid @enderror">
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>
@endsection
