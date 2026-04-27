@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl">

    <h1 class="text-2xl font-semibold mb-6">Edit Prosedur</h1>

    <form action="{{ route('prosedur.update', $prosedur) }}"
          method="POST"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori_id"
                    class="w-full border rounded px-3 py-2 @error('kategori_id') border-red-500 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}"
                        {{ old('kategori_id', $prosedur->kategori_id) == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text"
                   name="judul"
                   value="{{ old('judul', $prosedur->judul) }}"
                   class="w-full border rounded px-3 py-2 @error('judul') border-red-500 @enderror">
            @error('judul')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="deskripsi"
                      rows="5"
                      class="w-full border rounded px-3 py-2 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $prosedur->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Urutan Tampil</label>
            <input type="number"
                   name="urutan"
                   value="{{ old('urutan', $prosedur->urutan) }}"
                   min="1"
                   class="w-full border rounded px-3 py-2 @error('urutan') border-red-500 @enderror">
            @error('urutan')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Status</label>
            <select name="is_active" class="w-full border rounded px-3 py-2">
                <option value="1" {{ old('is_active', $prosedur->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $prosedur->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3 pt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('prosedur.index') }}"
               class="px-4 py-2 rounded border">
                Kembali
            </a>
        </div>
    </form>

</div>
@endsection
