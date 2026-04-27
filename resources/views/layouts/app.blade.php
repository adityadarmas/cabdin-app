<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Cabdin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-100 text-gray-800">

<!-- HEADER -->
<header class="bg-slate-800 text-white sticky top-0 z-20">
    <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center gap-3">
            <!-- Hamburger (mobile only) -->
            <button id="sidebar-toggle"
                    class="p-1.5 rounded-lg hover:bg-slate-700 transition md:hidden"
                    aria-label="Buka menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="text-lg font-semibold">E-Cabdin</h1>
        </div>
        <span class="text-sm text-slate-300">
            Selamat Datang, <strong class="text-white">{{ auth()->user()->name }}</strong>
        </span>
    </div>
</header>

<!-- BACKDROP (mobile) -->
<div id="sidebar-backdrop"
     class="fixed inset-0 bg-black/50 z-30 hidden"
     aria-hidden="true"></div>

<!-- MAIN LAYOUT -->
<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div id="sidebar"
         class="fixed inset-y-0 left-0 z-40 bg-slate-700 overflow-y-auto
                transition-transform duration-200 -translate-x-full
                md:static md:translate-x-0 md:transition-none md:shrink-0">
        @include('partials.sidebars.' . auth()->user()->role)
    </div>

    <!-- CONTENT -->
    <main class="flex-1 min-w-0 p-4 md:p-6 bg-white">
        @include('partials.alert')
        @yield('content')
    </main>

</div>

<script>
    const sidebarEl  = document.getElementById('sidebar');
    const backdropEl = document.getElementById('sidebar-backdrop');
    const toggleBtn  = document.getElementById('sidebar-toggle');

    function openSidebar() {
        sidebarEl.classList.remove('-translate-x-full');
        backdropEl.classList.remove('hidden');
    }
    function closeSidebar() {
        sidebarEl.classList.add('-translate-x-full');
        backdropEl.classList.add('hidden');
    }

    toggleBtn.addEventListener('click', () => {
        sidebarEl.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
    });

    backdropEl.addEventListener('click', closeSidebar);
</script>

@stack('scripts')
</body>
</html>
