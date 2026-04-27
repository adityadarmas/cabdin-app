@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl">

    <h1 class="text-2xl font-semibold mb-6">Tambah Kategori Prosedur</h1>

    <form action="{{ route('kategori-prosedur.store') }}"
          method="POST"
          class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium mb-1">Nama Kategori</label>
            <input type="text"
                   name="nama"
                   value="{{ old('nama') }}"
                   placeholder="Contoh: Pelayanan Administrasi"
                   class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
            @error('nama')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Urutan Tampil</label>
            <input type="number"
                   name="urutan"
                   value="{{ old('urutan', 1) }}"
                   min="1"
                   class="w-full border rounded px-3 py-2 @error('urutan') border-red-500 @enderror">
            @error('urutan')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Status</label>
            <select name="is_active" class="w-full border rounded px-3 py-2">
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3 pt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>
            <a href="{{ route('kategori-prosedur.index') }}"
               class="px-4 py-2 rounded border">
                Kembali
            </a>
        </div>
    </form>

</div>
@endsection
