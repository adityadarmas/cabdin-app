<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::latest()
        ->paginate(9);
        return view('dashboard.produk.index', compact('data'));
    }

    public function allindex()
    {
        $data = Produk::where('is_active', 1)
            ->latest()
            ->paginate(9);

        return view('dashboard.produk.allindex', compact('data'));
    } 

    public function create()
    {
        return view('dashboard.produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga'     => 'required|numeric',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request->file('gambar')
        ->store('produk', 'public');
        }

        $validated['is_active'] = 0;

        Produk::create($validated);

        // Redirect dinamis berdasarkan role
        if (auth()->check() && auth()->user()->role === 'staff') {
            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan');
        }else{
            return redirect()
                ->route('landing')
                ->with('success', 'Produk berhasil ditambahkan');
        }

        
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
