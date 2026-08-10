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
            <a href="{{ route('operator.produk.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('operator.produk.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Manajemen Produk
            </a>
        </li>

        <li>
            <a href="{{ route('operator.pengajuan.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('operator.pengajuan.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Pengajuan Saya
            </a>
        </li>

        <li>
            <a href="{{ route('operator.notifikasi.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('operator.notifikasi.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Notifikasi
            </a>
        </li>

        <li>
            <a href="{{ route('operator.akun.edit') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('operator.akun.*') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Edit Akun
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
