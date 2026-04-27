@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-6">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('surat-keluar.index') }}"
               class="text-slate-500 hover:text-slate-700 transition text-sm">
                &larr; Kembali
            </a>
            <h3 class="text-2xl font-bold text-slate-800">Edit Surat Keluar</h3>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat-keluar.update', $suratKeluar) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Nomor Surat
                    </label>
                    <div class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2 text-sm font-mono text-slate-700">
                        {{ $suratKeluar->nomor_surat }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Judul Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul_surat"
                           value="{{ old('judul_surat', $suratKeluar->judul_surat) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Judul atau perihal surat">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Tanggal Terbit <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_terbit"
                           value="{{ old('tanggal_terbit', $suratKeluar->tanggal_terbit?->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                        Perbarui
                    </button>
                    <a href="{{ route('surat-keluar.index') }}"
                       class="px-5 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition text-sm font-medium">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
