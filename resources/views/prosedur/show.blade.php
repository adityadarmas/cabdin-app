@php
    $konten = $prosedur->deskripsi;
    if ($konten === strip_tags($konten)) {
        $konten = '<p>'.nl2br(e($konten)).'</p>';
    }

    $berita = (object) [
        'judul' => $prosedur->judul,
        'konten' => $konten,
        'tanggal' => $prosedur->updated_at,
        'thumbnail' => $prosedur->thumbnail,
    ];

    $related = $related->map(fn ($item) => (object) [
        'id' => $item->id,
        'judul' => $item->judul,
        'tanggal' => $item->updated_at,
        'thumbnail' => $item->thumbnail,
    ]);

    $detail = [
        'index_url' => route('landing').'#prosedur',
        'index_label' => 'Prosedur',
        'hero_category' => $prosedur->kategori?->nama ?? 'Prosedur Pelayanan',
        'meta_label' => 'Prosedur #'.$prosedur->urutan,
        'related_title' => 'Prosedur Lainnya',
        'show_route' => 'prosedur.show',
        'content_label' => 'Panduan Prosedur',
        'share_label' => 'Bagikan prosedur ini',
        'date_prefix' => 'Diperbarui',
    ];
@endphp

@include('berita.show')
