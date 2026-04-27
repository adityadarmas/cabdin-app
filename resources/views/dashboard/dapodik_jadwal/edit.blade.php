@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('prosedur.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-semibold">
            Edit Jadwal {{ \App\Models\DapodikJadwal::JENIS_LABEL[$jenis] }} Dapodik
        </h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('dapodik-jadwal.update', $jenis) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Mulai
                </label>
                <input type="date"
                       name="tanggal_mulai"
                       value="{{ old('tanggal_mulai', $jadwal->tanggal_mulai?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Selesai
                </label>
                <input type="date"
                       name="tanggal_selesai"
                       value="{{ old('tanggal_selesai', $jadwal->tanggal_selesai?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Keterangan <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea name="keterangan"
                          rows="3"
                          maxlength="500"
                          placeholder="Contoh: Semester genap 2025/2026"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 text-sm font-medium">
                    Simpan
                </button>
                <a href="{{ route('prosedur.index') }}"
                   class="text-gray-600 hover:text-gray-800 text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
