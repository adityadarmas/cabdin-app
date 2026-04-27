@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">

    <h2 class="text-xl font-semibold text-slate-800 mb-4">
        Edit Data Tamu
    </h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-700 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tamu.update', $tamu) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- NAMA -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Nama
            </label>
            <input
                type="text"
                name="nama"
                value="{{ old('nama', $tamu->nama) }}"
                required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
        </div>

        <!-- ASAL -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Asal
            </label>
            <input
                type="text"
                name="asal"
                value="{{ old('asal', $tamu->asal) }}"
                required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
        </div>

        <!-- KEPERLUAN -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Keperluan
            </label>
            <textarea
                name="keperluan"
                rows="4"
                required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">{{ old('keperluan', $tamu->keperluan) }}</textarea>
        </div>

        <!-- NOMOR HP -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Nomor HP / WhatsApp
            </label>
            <input
                type="text"
                name="nomor_hp"
                value="{{ old('nomor_hp', $tamu->nomor_hp) }}"
                placeholder="Contoh: 08123456789"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
        </div>

        <!-- ACTION BUTTON -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('tamu.create') }}"
               class="text-sm text-slate-500 hover:text-slate-700 transition">
                ← Kembali
            </a>

            <button type="submit"
                    class="bg-sky-500 hover:bg-sky-600 text-white
                           px-5 py-2 rounded-lg text-sm transition">
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>
@endsection
