{{-- staff.blade.php --}}
<aside class="w-64 text-white min-h-screen p-4">
    

    <ul class="space-y-2">

        <!-- DASHBOARD -->
        <li>
            <a href="{{ route('surat-masuk.index') }}"
               class="block px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('surat-masuk.index') ? 'bg-slate-600' : 'hover:bg-slate-400' }}">
                Dashboard
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