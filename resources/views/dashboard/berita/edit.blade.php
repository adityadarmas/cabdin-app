@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Edit Berita</h3>

    <form action="{{ route('berita.update', $berita) }}" method="POST">
    @csrf
    @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text"
                   name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul', $berita->judul) }}">
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date"
                   name="tanggal"
                   class="form-control @error('tanggal') is-invalid @enderror"
                   value="{{ old('tanggal', $berita->tanggal) }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea name="konten"
                      rows="5"
                      class="form-control @error('konten') is-invalid @enderror">{{ old('konten', $berita->konten) }}</textarea>
            @error('konten')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($berita->thumbnail)
            <div class="mb-3">
                <label class="form-label">Thumbnail Saat Ini</label><br>
                <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                     width="120">
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Ganti Thumbnail</label>
            <input type="file"
                   name="thumbnail"
                   class="form-control @error('thumbnail') is-invalid @enderror">
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>
@endsection
