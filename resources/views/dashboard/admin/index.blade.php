@extends('layouts.app')

@section('content')
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Manajemen User</h1>

            <a href="{{ route('admin.register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah User
            </a>
        </div>


        <!-- REGISTER LINK -->
        {{-- <div class="mt-8 text-center">
            <p class="text-slate-600">
                Belum punya akun?
                <a href="{{ url('/register') }}" class="font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div> --}}

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-center">Role</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($users ?? [] as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-4 py-2 font-medium">
                                {{ $item->name }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{ $item->role }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $item->email }}
                            </td>

                            <td class="px-4 py-2 text-center space-x-2">

                                {{-- FORM UPDATE PASSWORD --}}
                                <form action="{{ route('admin.users.updatePassword', $item->id) }}" method="POST"
                                    class="inline-block space-x-2"
                                    onsubmit="return confirm('Yakin ganti password user ini?')">

                                    @csrf
                                    @method('PUT')

                                    <input type="password" name="password" placeholder="Password baru" required
                                        class="border rounded px-2 py-1 text-sm w-32">

                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi" required
                                        class="border rounded px-2 py-1 text-sm w-32">

                                    <button type="submit" class="text-blue-600 hover:underline">
                                        Update
                                    </button>
                                </form>

                                {{-- FORM DELETE --}}
                                <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                User tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>
@endsection
