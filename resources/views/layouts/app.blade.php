<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard E-Cabdin')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        :root { --blue:#3B6FE8; --purple:#4153f8; --grad:linear-gradient(135deg,#3B6FE8 0%,#78a0f7 50%,#2f9df7 100%); --page:#f5f6fa; --ink:#1a1a2e; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--page); color:var(--ink); }
        .app-topbar { background:var(--grad); box-shadow:0 5px 22px rgba(59,111,232,.22); }
        .app-sidebar { background:linear-gradient(165deg,#172554 0%,#1e3a8a 56%,#273dba 100%); box-shadow:8px 0 28px rgba(30,58,138,.09); }
        .app-sidebar a { color:rgba(255,255,255,.78); font-weight:600; }
        .app-sidebar a:hover,.app-sidebar a.bg-slate-600 { color:white!important; background:rgba(255,255,255,.15)!important; }
        .app-sidebar button { color:rgba(255,255,255,.78); font-weight:600; }.app-sidebar button:hover{background:rgba(239,68,68,.8)!important;color:white}
        .content-surface { background:linear-gradient(180deg,#fff 0%,#f7f9ff 100%); min-height:calc(100vh - 64px); }
    </style>
    @stack('styles')
</head>
<body>
    <header class="app-topbar sticky top-0 z-30 h-16 text-white">
        <div class="h-full flex items-center justify-between px-4 md:px-7">
            <div class="flex items-center gap-3"><button id="sidebar-toggle" class="md:hidden p-2 rounded-lg hover:bg-white/15" aria-label="Buka menu"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button><a href="{{ route('landing') }}" class="flex items-center gap-2.5"><img src="{{ asset('favicon.png') }}" class="h-9 w-9 object-contain" alt="E-Cabdin"><span class="font-extrabold tracking-wide text-[15px]">E-CABDIN</span></a><span class="hidden sm:block h-6 w-px bg-white/25"></span><span class="hidden sm:block text-xs text-white/75">Portal Administrasi</span></div>
            <div class="flex items-center gap-3"><a href="{{ route('landing') }}" class="hidden sm:inline-flex text-xs font-semibold text-white/80 hover:text-white">Lihat Beranda</a><div class="flex items-center gap-2.5 rounded-full border border-white/25 bg-white/12 py-1.5 pl-2 pr-3"><div class="grid h-7 w-7 place-items-center rounded-full bg-white text-xs font-extrabold text-blue-600">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div><div class="hidden sm:block leading-tight"><div class="text-xs font-bold">{{ auth()->user()->name }}</div><div class="text-[10px] uppercase tracking-wider text-white/65">{{ auth()->user()->role }}</div></div></div></div>
        </div>
    </header>
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-slate-950/45 md:hidden"></div>
    <div class="flex min-h-[calc(100vh-64px)]">
        <aside id="sidebar" class="app-sidebar fixed inset-y-16 left-0 z-50 w-68 overflow-y-auto -translate-x-full transition-transform duration-200 md:static md:translate-x-0 md:shrink-0"><div class="px-6 pt-6 pb-3 text-[10px] font-bold uppercase tracking-[.16em] text-white/45">Menu {{ auth()->user()->role }}</div>@include('partials.sidebars.' . auth()->user()->role)</aside>
        <main class="content-surface min-w-0 flex-1 p-4 md:p-7">@include('partials.alert')@yield('content')</main>
    </div>
    <script>
        const sidebarEl=document.getElementById('sidebar'),backdropEl=document.getElementById('sidebar-backdrop'),toggleBtn=document.getElementById('sidebar-toggle');
        const openSidebar=()=>{sidebarEl.classList.remove('-translate-x-full');backdropEl.classList.remove('hidden')},closeSidebar=()=>{sidebarEl.classList.add('-translate-x-full');backdropEl.classList.add('hidden')};
        toggleBtn?.addEventListener('click',()=>sidebarEl.classList.contains('-translate-x-full')?openSidebar():closeSidebar());backdropEl?.addEventListener('click',closeSidebar);
    </script>
    @stack('scripts')
</body>
</html>
