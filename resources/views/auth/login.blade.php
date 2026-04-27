<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - E-Cabdin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-sky-50 via-blue-50 to-sky-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-md">
    <!-- Logo & Title -->
    <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-sky-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-2xl">E</span>
            </div>
            <span class="text-3xl font-bold bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">E-CABDIN</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Selamat Datang Kembali</h1>
        <p class="text-slate-600">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Login Form -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-sky-100">
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            <!-- EMAIL -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-slate-700">
                    Email
                </label>
                <div class="relative">
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                        placeholder="nama@email.com"
                    >
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                @error('email') 
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-semibold text-slate-700">
                    Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                        placeholder="••••••••"
                    >
                    <button 
                        type="button"
                        onclick="togglePassword()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                    >
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- REMEMBER & FORGOT -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="remember"
                        class="w-4 h-4 text-sky-600 bg-slate-50 border-slate-300 rounded focus:ring-2 focus:ring-sky-500"
                    >
                    <span class="text-sm text-slate-600">Ingat saya</span>
                </label>
                <a href="#" class="text-sm font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                    Lupa password?
                </a>
            </div>

            <!-- SUBMIT BUTTON -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:shadow-xl hover:scale-[1.02] transition-all duration-300"
            >
                Login
            </button>
        </form>

        <!-- REGISTER LINK -->
        {{-- <div class="mt-8 text-center">
            <p class="text-slate-600">
                Belum punya akun?
                <a href="{{ url('/register') }}" class="font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div> --}}

    <!-- BACK TO HOME -->
    <div class="text-center mt-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm font-medium">Kembali ke Beranda</span>
        </a>
    </div>

    <!-- FOOTER -->
    <p class="text-center text-xs text-slate-400 mt-8">
        © {{ date('Y') }} E-Cabdin
    </p>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
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
</script>

</body>
</html>


{{-- kode lama
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-sky-50 text-slate-800">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <!-- TITLE -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-sky-500">
                E-CABDIN
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <!-- FORM -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-sky-400"
                >

                @error('email')
                    <p class="text-xs text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-sky-400"
                >
            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="w-full bg-sky-500 hover:bg-sky-400 text-white py-2.5 rounded-lg
                       font-semibold transition shadow"
            >
                Login
            </button>
        </form>

        <!-- FOOTER -->
        <p class="text-center text-xs text-slate-400 mt-6">
            © {{ date('Y') }} E-Cabdin
        </p>

    </div>

</body>
</html> --}}
