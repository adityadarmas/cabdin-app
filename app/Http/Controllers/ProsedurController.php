<?php

namespace App\Http\Controllers;

use App\Models\Prosedur;
use Illuminate\Http\Request;

class ProsedurController extends Controller
{
    public function index()
    {
        $data = Prosedur::latest()->get();
        return view('dashboard.prosedur.index', compact('data'));
    }

    public function show(Prosedur $prosedur)
    {
        return view('dashboard.prosedur.show', compact('prosedur'));
    }

    public function create()
    {
        return view('dashboard.prosedur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required',
            'is_active' => 'required|boolean'
        ]);

        Prosedur::create($validated);

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Prosedur berhasil ditambahkan');
    }

    public function edit(Prosedur $prosedur)
    {
        return view('dashboard.prosedur.edit', compact('prosedur'));
    }

    public function update(Request $request, Prosedur $prosedur)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required',
            'is_active' => 'required|boolean'
        ]);

        $prosedur->update($validated);

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Prosedur berhasil diperbarui');
    }

    public function destroy(Prosedur $prosedur)
    {
        $prosedur->delete();

        return redirect()
            ->route('prosedur.index')
            ->with('success', 'Prosedur berhasil dihapus');
    }
}
