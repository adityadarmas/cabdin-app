<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Produk - E-Cabdin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-sky-50 via-blue-50 to-sky-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-7xl mx-auto px-6 py-12">

        <h1 class="text-3xl font-bold mb-8">Semua Produk</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($data as $item)
            <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">

                <img src="{{ asset('storage/'.$item->gambar) }}"
                    class="h-48 w-full object-cover">

                <div class="p-4">
                    <h2 class="font-bold text-lg">{{ $item->nama }}</h2>
                    <p class="text-sm text-gray-600 line-clamp-2">
                        {{ $item->deskripsi }}
                    </p>

                    <div class="mt-3 flex justify-between items-center">
                        <span class="font-bold text-blue-600">
                            Rp {{ number_format($item->harga,0,',','.') }}
                        </span>

                        <a href="{{ route('produk.show', $item) }}"
                        class="text-sm text-blue-600 hover:underline">
                            Detail
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $data->links() }}
        </div>
    </div>

</body>
</html>