<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    {{-- Tailwind CDN (sementara, untuk production sebaiknya pakai build) --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 text-gray-800">

<!-- HEADER -->
<header class="bg-slate-800 text-white">
    <div class="flex items-center justify-between px-6 py-4">
        <h1 class="text-xl font-semibold">E-Cabdin</h1>
        <span class="text-sm">
            Selamat Datang, <strong>{{ auth()->user()->name }}</strong>
        </span>
    </div>
</header>

<!-- MAIN LAYOUT -->
<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-56 bg-slate-700 text-white px-4 py-6">
        @include('partials.sidebars.' . auth()->user()->role)
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-6 bg-white">

        {{-- Alert --}}
        @include('partials.alert')

        {{-- Page Content --}}
        @yield('content')

    </main>

</div>

</body>
</html>
