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
                                <div class="flex items-center justify-center gap-2">
                                    {{-- FORM UPDATE PASSWORD --}}
                                    <form action="{{ route('admin.users.updatePassword', $item->id) }}" method="POST"
                                        class="inline-flex items-center gap-1.5"
                                        onsubmit="return confirm('Yakin ganti password user ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="password" name="password" placeholder="Password baru" required
                                            class="border border-gray-200 rounded-lg px-2 py-1 text-xs w-28 focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        <input type="password" name="password_confirmation" placeholder="Konfirmasi" required
                                            class="border border-gray-200 rounded-lg px-2 py-1 text-xs w-28 focus:outline-none focus:ring-1 focus:ring-blue-400">
                                        <button type="submit"
                                                class="text-blue-600 hover:text-blue-800 text-xs font-medium hover:underline">
                                            Update
                                        </button>
                                    </form>

                                    {{-- FORM DELETE --}}
                                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">
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
@endsection
