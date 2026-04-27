@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl">

    <h1 class="text-2xl font-semibold mb-6">Edit Berita</h1>

    <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block font-medium mb-1">Judul</label>
            <input type="text"
                   name="judul"
                   value="{{ old('judul', $berita->judul) }}"
                   class="w-full border rounded px-3 py-2 @error('judul') border-red-500 @enderror">
            @error('judul')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block font-medium mb-1">Tanggal</label>
            <input type="date"
                   name="tanggal"
                   class="form-control @error('tanggal') is-invalid @enderror w-full border rounded px-3 py-2"
                   value="{{ old('tanggal', \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d')) }}">
            @error('tanggal')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block font-medium mb-1">Konten</label>
            <textarea name="konten"
                      rows="5"
                      class="form-control @error('konten') is-invalid @enderror w-full border rounded px-3 py-2">{{ old('konten', $berita->konten) }}</textarea>
            @error('konten')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block font-medium mb-1">Status</label>
            <select name="is_active"
                    class="form-control @error('is_active') is-invalid @enderror w-full border rounded px-3 py-2">
                <option value="1" {{ old('is_active', $berita->is_active) == '1' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="0" {{ old('is_active', $berita->is_active) == '0' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
            @error('is_active')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($berita->thumbnail)
            <div class="mb-3">
                <label class="form-label">Thumbnail Saat Ini</label><br>
                <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                     width="120" class="rounded">
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

        <div class="flex gap-3 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('berita.index') }}"
               class="px-4 py-2 rounded border">
                Kembali
            </a>
        </div>

    </form>

</div>
@endsection