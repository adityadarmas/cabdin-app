@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Akun</h1>
        <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi akun Anda</p>
    </div>

    @if (session('success'))
        <div class="mb-5 p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        <form action="{{ route('operator.akun.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-5">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border @error('name') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border @error('email') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Masukkan email">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. WhatsApp --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">No. WhatsApp</label>
                    <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}"
                        class="w-full border @error('no_wa') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Contoh: 08123456789">
                    @error('no_wa')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ganti Password --}}
                <div class="border-t border-gray-100 pt-5">
                    <button type="button" id="togglePasswordBtn" onclick="togglePassword()"
                        class="flex items-center gap-2 text-xs font-medium text-gray-500 hover:text-blue-600 transition">
                        <svg id="togglePasswordIcon" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        Ganti Password
                    </button>

                    <div id="passwordSection" class="{{ $errors->hasAny(['password']) ? '' : 'hidden' }} mt-4 space-y-4">

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Password Baru</label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="w-full border @error('password') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent pr-10"
                                    placeholder="Minimal 6 karakter">
                                <button type="button" onclick="toggleVisibility('password', 'eye1')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg id="eye1" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent pr-10"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="toggleVisibility('password_confirmation', 'eye2')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg id="eye2" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 rounded-b-xl flex justify-end border-t border-gray-100">
                <button type="submit"
                    class="px-5 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    function togglePassword() {
        const section = document.getElementById('passwordSection');
        const icon    = document.getElementById('togglePasswordIcon');
        const hidden  = section.classList.contains('hidden');
        section.classList.toggle('hidden');
        icon.style.transform = hidden ? 'rotate(90deg)' : '';
    }

    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        input.type  = input.type === 'password' ? 'text' : 'password';
    }

    // Buka section password otomatis jika ada error validasi
    document.addEventListener('DOMContentLoaded', function () {
        const section = document.getElementById('passwordSection');
        if (!section.classList.contains('hidden')) {
            document.getElementById('togglePasswordIcon').style.transform = 'rotate(90deg)';
        }
    });
</script>
@endsection
