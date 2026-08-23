<aside class="w-64 text-white min-h-screen p-4">

    <ul class="space-y-2">

        <li>
            <a href="{{ route('operator.dashboard') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('operator.dashboard') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Dashboard
            </a>
        </li>

        <li>
            <details @if(request()->routeIs('operator.pengajuan.*') || request()->routeIs('operator.produk.*')) open @endif>
                <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 transition {{ request()->routeIs('operator.pengajuan.*') || request()->routeIs('operator.produk.*') ? 'bg-slate-600 text-white' : 'hover:bg-slate-400' }}">
                    <span>Menu</span>
                    <svg class="h-4 w-4 transition-transform [[open]_&]:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                </summary>
                <ul class="mt-1 space-y-1 border-l border-white/20 pl-3">
                    <li><a href="{{ route('operator.pengajuan.index') }}" class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('operator.pengajuan.*') ? 'bg-white/15 text-white' : 'hover:bg-white/10' }}">Pengumpulan Data</a></li>
                    <li><a href="{{ route('operator.produk.index') }}" class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('operator.produk.*') ? 'bg-white/15 text-white' : 'hover:bg-white/10' }}">Manajemen Produk</a></li>
                </ul>
            </details>
        </li>

        <li>
            <a href="{{ route('operator.akun.edit') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('operator.akun.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Setting
            </a>
        </li>

        <li class="border-t border-slate-700 my-4"></li>

        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-500 transition">
                    Logout
                </button>
            </form>
        </li>

    </ul>
</aside>
