@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- KALENDER KHUSUS STAFF --}}
        @can('viewAny', App\Models\SuratMasuk::class)
            @if (in_array(auth()->user()->role, ['staff', 'pimpinan']))
                <div class="mb-6">
                    @include('surat_masuk.partials.calendar')
                </div>
            @endif
        @endcan

        <!-- TABLE WRAPPER -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-16">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Nomor Surat</th>
                        <th class="px-4 py-3 text-left font-semibold">Perihal</th>
                        <th class="px-4 py-3 text-left font-semibold w-48">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse ($suratMasuk as $surat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() }}
                            </td>

                            <td class="px-4 py-3 text-slate-800">
                                {{ $surat->nomor_surat }}
                            </td>

                            <td class="px-4 py-3 text-slate-700">
                                {{ $surat->perihal }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">

                                    <!-- DETAIL -->
                                    <a href="{{ route('surat-masuk.show', $surat) }}"
                                        class="px-3 py-1.5 rounded-md bg-sky-500 text-white hover:bg-sky-600 transition text-xs">
                                        @if (auth()->user()->role === 'pimpinan')
                                            Teruskan
                                        @else
                                            Detail
                                        @endif
                                    </a>



                                    {{-- TU --}}
                                    @can('update', $surat)
                                        <a href="{{ route('surat-masuk.edit', $surat) }}"
                                            class="px-3 py-1.5 rounded-md bg-amber-500 text-white
                                              hover:bg-amber-600 transition text-xs">
                                            Edit
                                        </a>
                                    @endcan

                                    {{-- TU --}}
                                    @can('delete', $surat)
                                        <form action="{{ route('surat-masuk.destroy', $surat) }}" method="POST"
                                            onsubmit="return confirm('Hapus surat?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-md bg-red-500 text-white
                                                       hover:bg-red-600 transition text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-500">
                                Belum ada data surat masuk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $suratMasuk->links() }}
        </div>

    </div>
@endsection



{{-- =================================kode lama==========================================

@extends('layouts.admin')

@section('content')
<h1>Surat Masuk</h1>
`
<a href="{{ route('surat.create') }}">Tambah Surat</a>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<table border="1">
    <tr>
        <th>No</th>
        <th>Nomor Surat</th>
        <th>Perihal</th>
        <th>Asal</th>
        <th>Aksi</th>
    </tr>
    @foreach ($suratMasuk as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nomor_surat }}</td>
        <td>{{ $item->perihal }}</td>
        <td>{{ $item->asal }}</td>
        <td>
            <a href="{{ route('surat.show', $item) }}">Detail</a>
            <a href="{{ route('surat.edit', $item) }}">Edit</a>

            <form action="{{ route('surat.destroy', $item) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Hapus data?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $suratMasuk->links() }}
@endsection --}}
