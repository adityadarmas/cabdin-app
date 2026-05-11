@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola akun pengguna sistem</p>
        </div>
        <a href="{{ route('admin.register') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm">
            + Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
            </span>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari nama, email, atau nama sekolah..."
                class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <button type="submit"
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
            Cari
        </button>
        @if ($search)
            <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 text-sm border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                Reset
            </a>
        @endif
    </form>

    @if ($search)
        <p class="mb-3 text-sm text-gray-500">
            Hasil pencarian untuk <span class="font-medium text-gray-700">"{{ $search }}"</span>
            — {{ $users->total() }} user ditemukan
        </p>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Sekolah</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users ?? [] as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-400 text-xs">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $item->name }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->email }}
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    $roleColor = match($item->role) {
                                        'admin'    => 'bg-purple-100 text-purple-700',
                                        'operator' => 'bg-blue-100 text-blue-700',
                                        'staff'    => 'bg-green-100 text-green-700',
                                        'tu'       => 'bg-orange-100 text-orange-700',
                                        'pimpinan' => 'bg-red-100 text-red-700',
                                        default    => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">
                                    {{ ucfirst($item->role) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-600 text-xs">
                                @if ($item->role === 'operator' && $item->nama_sekolah)
                                    <span class="inline-flex items-center gap-1">
                                        &#127983; {{ $item->nama_sekolah }}
                                    </span>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ $item->email }}', '{{ $item->role }}', '{{ addslashes($item->nama_sekolah ?? '') }}')"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l1.586 1.586a1 1 0 010 1.414L12 16H9v-3z"/>
                                        </svg>
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 text-xs font-medium text-red-600 hover:text-red-800 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 01-1-1V5a1 1 0 011-1h6a1 1 0 011 1v1a1 1 0 01-1 1H9z"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <p class="font-medium text-gray-500">User tidak ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>

{{-- MODAL EDIT AKUN --}}
<div id="modalEditAkun" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md mx-4">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Edit Akun Pengguna</h2>
                <p id="modal_subtitle" class="text-xs text-gray-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="closeEditModal()"
                class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="formEditAkun" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-4">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Masukkan nama lengkap">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                    <input type="email" id="edit_email" name="email" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Masukkan email">
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Role</label>
                    <select id="edit_role" name="role" required onchange="toggleNamaSekolah()"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent bg-white">
                        @foreach (['admin', 'staff', 'tu', 'pimpinan', 'operator'] as $r)
                            <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Sekolah (hanya operator) --}}
                <div id="namaSekolahWrapper" class="hidden">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Nama Sekolah</label>
                    <input type="text" id="edit_nama_sekolah" name="nama_sekolah"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Masukkan nama sekolah">
                </div>

                {{-- Divider ganti password --}}
                <div class="border-t border-gray-100 pt-4">
                    <button type="button" id="togglePasswordBtn" onclick="togglePassword()"
                        class="flex items-center gap-2 text-xs font-medium text-gray-500 hover:text-blue-600 transition">
                        <svg id="togglePasswordIcon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        Ganti Password
                    </button>

                    <div id="passwordSection" class="hidden mt-3 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Password Baru</label>
                            <div class="relative">
                                <input type="password" id="edit_password" name="password"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent pr-10"
                                    placeholder="Minimal 6 karakter">
                                <button type="button" onclick="toggleVisibility('edit_password', 'eye1')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg id="eye1" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" id="edit_password_confirmation" name="password_confirmation"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent pr-10"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="toggleVisibility('edit_password_confirmation', 'eye2')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg id="eye2" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 rounded-b-xl flex justify-end gap-2 border-t border-gray-100">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-100 transition font-medium">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const updateBaseUrl = "{{ route('admin.users.update', ':id') }}";

    function openEditModal(id, name, email, role, namaSekolah) {
        document.getElementById('edit_name').value  = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value  = role;
        document.getElementById('edit_nama_sekolah').value = namaSekolah || '';
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_password_confirmation').value = '';
        document.getElementById('modal_subtitle').textContent = email;
        document.getElementById('formEditAkun').action = updateBaseUrl.replace(':id', id);

        // Reset section password
        document.getElementById('passwordSection').classList.add('hidden');
        document.getElementById('togglePasswordIcon').style.transform = '';

        // Tampilkan nama sekolah sesuai role
        toggleNamaSekolah();

        document.getElementById('modalEditAkun').classList.remove('hidden');
    }

    function toggleNamaSekolah() {
        const role    = document.getElementById('edit_role').value;
        const wrapper = document.getElementById('namaSekolahWrapper');
        wrapper.classList.toggle('hidden', role !== 'operator');
    }

    function closeEditModal() {
        document.getElementById('modalEditAkun').classList.add('hidden');
    }

    function togglePassword() {
        const section = document.getElementById('passwordSection');
        const icon    = document.getElementById('togglePasswordIcon');
        const hidden  = section.classList.contains('hidden');
        section.classList.toggle('hidden');
        icon.style.transform = hidden ? 'rotate(90deg)' : '';
        if (!hidden) {
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_password_confirmation').value = '';
        }
    }

    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        input.type  = input.type === 'password' ? 'text' : 'password';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeEditModal();
    });
</script>
@endsection
