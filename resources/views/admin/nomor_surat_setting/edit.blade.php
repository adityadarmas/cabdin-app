@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-6">

        <div class="flex items-center gap-3 mb-6">
            <h3 class="text-2xl font-bold text-slate-800">Pengaturan Nomor Surat Keluar</h3>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

            <p class="text-sm text-slate-500 mb-5">
                Nomor surat berikutnya:
                <span class="font-mono font-semibold text-blue-600">
                    {{ str_pad($setting->counter + 1, $setting->padding, '0', STR_PAD_LEFT) }}
                </span>
            </p>

            <form action="{{ route('admin.nomor-surat-setting.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Counter Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="counter" value="{{ old('counter', $setting->counter) }}"
                           min="0"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-slate-400 mt-1">Nomor urut terakhir yang telah digunakan. Surat berikutnya akan menggunakan nomor ini + 1.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Digit Padding <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="padding" value="{{ old('padding', $setting->padding) }}"
                           min="1" max="6"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-slate-400 mt-1">Jumlah digit nomor urut (contoh: 3 → 001, 004, 012).</p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
