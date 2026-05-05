<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::with('operator')->latest()->paginate(20);
        return view('dashboard.produk.index', compact('data'));
    }

    public function operatorIndex()
    {
        $data = Produk::where('user_id', auth()->id())->latest()->paginate(10);
        return view('operator.produk.index', compact('data'));
    }

    public function show(Produk $produk)
    {
        abort_if($produk->user_id !== auth()->id(), 403);
        return view('operator.produk.show', compact('produk'));
    }

    public function operatorEdit(Produk $produk)
    {
        abort_if($produk->user_id !== auth()->id(), 403);
        return view('operator.produk.edit', compact('produk'));
    }

    public function operatorUpdate(Request $request, Produk $produk)
    {
        abort_if($produk->user_id !== auth()->id(), 403);
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:jasa,makanan,minuman,kerajinan,pertanian,teknologi,lainnya',
            'deskripsi' => 'required',
            'harga'     => 'required|numeric',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('operator.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function operatorDestroy(Produk $produk)
    {
        abort_if($produk->user_id !== auth()->id(), 403);
        $produk->delete();
        return redirect()->route('operator.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function allindex(Request $request)
    {
        $kategori = $request->query('kategori');

        $query = Produk::with('operator')
            ->where('is_active', 1);

        if ($kategori && $kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        // Kelompokkan per sekolah
        $sekolahList = $query->get()
            ->groupBy(fn($p) => $p->operator?->nama_sekolah ?? 'Umum');

        $totalProduk  = Produk::where('is_active', 1)->count();
        $totalSekolah = Produk::where('is_active', 1)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        return view('dashboard.produk.allindex', compact('sekolahList', 'totalProduk', 'totalSekolah', 'kategori'));
    }

    public function create()
    {
        return view('dashboard.produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:jasa,makanan,minuman,kerajinan,pertanian,teknologi,lainnya',
            'deskripsi' => 'required',
            'harga'     => 'required|numeric',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $validated['user_id']   = auth()->id();
        $validated['is_active'] = 0;

        Produk::create($validated);

        // // Redirect dinamis berdasarkan role
        // if (auth()->check() && auth()->user()->role === 'staff') {
        //     return redirect()
        //         ->route('produk.index')
        //         ->with('success', 'Produk berhasil ditambahkan');
        // }else{
        //     return redirect()
        //         ->route('landing')
        //         ->with('success', 'Produk berhasil ditambahkan');
        // }

        if (auth()->user()->role === 'operator') {
            return redirect()->route('operator.produk.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        }

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit(Produk $produk)
    {
        return view('dashboard.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga'    => 'required|numeric',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|boolean'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        } else {
            unset($validated['gambar']);
        }

        $produk->update($validated);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }

}
