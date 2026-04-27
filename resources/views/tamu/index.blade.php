<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Daftar Tamu</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-100 text-slate-800">

<div class="max-w-5xl mx-auto py-10 px-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Daftar Tamu
        </h2>

        <a href="{{ route('tamu.create') }}"
           class="bg-sky-500 hover:bg-sky-400 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
            + Tambah Tamu
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Alamat/Asal</th>
                    <th class="px-4 py-3 text-left">Keperluan</th>
                    <th class="px-4 py-3 text-left">No. HP</th>
                    {{-- <th class="px-4 py-3 text-center">Aksi</th> --}}
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($tamu as $item)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        {{ $loop->iteration + ($tamu->currentPage()-1) * $tamu->perPage() }}
                    </td>
                    <td class="px-4 py-3 font-medium">
                        {{ $item->nama }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->asal }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->keperluan }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->nomor_hp ?? '-' }}
                    </td>
                    {{-- <td class="px-4 py-3 text-center">
                        <a href="{{ route('tamu.edit', $item) }}"
                           class="inline-block bg-amber-400 hover:bg-amber-300 text-white px-3 py-1 rounded-md text-xs">
                            Edit
                        </a>
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-slate-400">
                        Belum ada data tamu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $tamu->links() }}
    </div>

</div>

</body>
</html>
