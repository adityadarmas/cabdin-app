<section class="max-w-4xl mx-auto py-16 px-4">
    <h1 class="text-4xl font-bold text-slate-900 mb-4">
        {{ $berita->judul }}
    </h1>

    <p class="text-slate-500 mb-6">
        {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
    </p>

    @if($berita->thumbnail)
        <img src="{{ asset('storage/'.$berita->thumbnail) }}"
             class="w-full rounded-xl mb-8">
    @endif

    <article class="prose prose-lg max-w-none">
        {!! $berita->konten !!}
    </article>
</section>
