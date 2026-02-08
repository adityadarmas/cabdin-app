<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - E-Cabdin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-sky-50 via-blue-50 to-sky-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-2xl">
    <!-- Logo & Title -->
    <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-sky-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-2xl">E</span>
            </div>
            <span class="text-3xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">E-CABDIN</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Buat Akun Baru</h1>
        <p class="text-slate-600">Daftar untuk mengakses layanan E-Cabdin</p>
    </div>

    <!-- Registration Form -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-sky-100">
        <form action="{{ url('/register') }}" method="POST" id="registerForm" class="space-y-6">
            @csrf
            <!-- Role Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">
                    Role Pengguna <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="staff" class="peer sr-only" {{ old('role') == 'staff' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-center transition-all peer-checked:border-sky-500 peer-checked:bg-sky-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-400 peer-checked:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-slate-700">Staff</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="tu" class="peer sr-only" {{ old('role') == 'tu' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-center transition-all peer-checked:border-sky-500 peer-checked:bg-sky-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-400 peer-checked:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-slate-700">TU</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="pimpinan" class="peer sr-only" {{ old('role') == 'pimpinan' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-center transition-all peer-checked:border-sky-500 peer-checked:bg-sky-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-400 peer-checked:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm font-semibold text-slate-700">Pimpinan</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role') == 'admin' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl text-center transition-all peer-checked:border-sky-500 peer-checked:bg-sky-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-400 peer-checked:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-slate-700">Admin</span>
                        </div>
                    </label>
                </div>
                @error('role') 
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-semibold text-slate-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                    placeholder="Masukkan nama lengkap Anda"
                >
                @error('name') 
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-slate-700">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                    placeholder="nama@email.com"
                >
                @error('email') 
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Password Fields -->
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-slate-700">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            required
                            minlength="8"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                            placeholder="Min. 8 karakter"
                        >
                        <button 
                            type="button"
                            onclick="togglePassword('password', 'eyeIcon1')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                        >
                            <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            required
                            minlength="8"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                            placeholder="Ulangi password"
                        >
                        <button 
                            type="button"
                            onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                        >
                            <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div id="passwordStrength" class="hidden">
                <div class="flex gap-2 mb-2">
                    <div class="h-2 flex-1 bg-slate-200 rounded-full overflow-hidden">
                        <div id="strengthBar" class="h-full transition-all duration-300"></div>
                    </div>
                </div>
                <p id="strengthText" class="text-xs"></p>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:shadow-xl hover:scale-[1.02] transition-all duration-300"
            >
                Daftar Sekarang
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-8 text-center">
            <p class="text-slate-600">
                Sudah punya akun?
                <a href="{{ url('/login') }}" class="font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm font-medium">Kembali ke Beranda</span>
        </a>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthIndicator = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length === 0) {
            strengthIndicator.classList.add('hidden');
            return;
        }
        
        strengthIndicator.classList.remove('hidden');
        
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        
        let color, text, width;
        
        if (strength <= 2) {
            color = 'bg-red-500';
            text = 'Password lemah';
            width = '33%';
        } else if (strength <= 3) {
            color = 'bg-yellow-500';
            text = 'Password sedang';
            width = '66%';
        } else {
            color = 'bg-green-500';
            text = 'Password kuat';
            width = '100%';
        }
        
        strengthBar.className = `h-full transition-all duration-300 ${color}`;
        strengthBar.style.width = width;
        strengthText.textContent = text;
        strengthText.className = `text-xs ${color.replace('bg-', 'text-')}`;
    });
</script>

</body>
</html>

{{-- kode lama --}}

{{-- <!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Daftar Akun</h2>

<form action="{{ url('/register') }}" method="POST">
    @csrf

    <div>
        <label>Nama:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <span style="color:red;">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <span style="color:red;">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Role:</label>
        <select name="role" required>
            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            <option value="tu" {{ old('role') == 'tu' ? 'selected' : '' }}>TU</option>
            <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        @error('role') <span style="color:red;">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Konfirmasi Password:</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Daftar</button>
</form>

<p>Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a></p>

</body>
</html> --}}
