{{-- staff.blade.php --}}
<aside class="w-64 text-white min-h-screen p-4">
    

    <ul class="space-y-2">

        <!-- Manajemen User -->
        <li>
            <a href="{{ route('surat-masuk.create') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('surat-masuk.create') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Manajemen User
            </a>
        </li>
        <!-- Dashboard berita-->
        <li>
            <a href="{{ route('berita.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('berita.index') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Dashboard Berita
            </a>
        </li>
        <!-- Dashboard Prosedur-->
        <li>
            <a href="{{ route('prosedur.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('prosedur.index') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Dashboard Prosedur
            </a>
        </li>
        <!-- Dashboard Produk-->
        <li>
            <a href="{{ route('produk.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('produk.index') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Dashboard Produk
            </a>
        </li>

        <!-- DIVIDER -->
        <li class="border-t border-slate-700 my-4"></li>

        <!-- LOGOUT -->
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg
                               hover:bg-red-500 transition">
                    Logout
                </button>
            </form>
        </li>

    </ul>
</aside>
