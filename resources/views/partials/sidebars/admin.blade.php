
{{-- staff.blade.php --}}
<aside class="w-64 text-white min-h-screen p-4">
    

    <ul class="space-y-2">

        <!-- Manajemen User -->
        <li>
            <a href="{{ route('admin.users.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('admin.users.index') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
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
        <!-- Manajemen Prosedur -->
        <li>
            <a href="{{ route('kategori-prosedur.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('kategori-prosedur.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Kategori Prosedur
            </a>
        </li>
        <li>
            <a href="{{ route('prosedur.index') }}"
               class="block px-4 py-2 pl-7 rounded-lg transition text-sm
                      {{ request()->routeIs('prosedur.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                ↳ Sub-Prosedur
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

        <!-- Surat Keluar -->
        <li>
            <a href="{{ route('surat-keluar.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('surat-keluar.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Nomor Surat Keluar
            </a>
        </li>
        <li>
            <a href="{{ route('admin.nomor-surat-setting.edit') }}"
               class="block px-4 py-2 pl-7 rounded-lg transition text-sm
                      {{ request()->routeIs('admin.nomor-surat-setting.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                ↳ Pengaturan Nomor
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
