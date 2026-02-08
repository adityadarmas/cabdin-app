<section class="max-w-4xl mx-auto py-16 px-4">
    <a href="{{ url()->previous() }}"
       class="text-sky-600 font-semibold mb-6 inline-block">
        ← Kembali
    </a>

    <h1 class="text-4xl font-bold text-slate-900 mb-6">
        {{ $prosedur->judul }}
    </h1>

    <div class="prose max-w-none text-slate-700">
        {!! nl2br(e($prosedur->deskripsi)) !!}
    </div>
</section>
