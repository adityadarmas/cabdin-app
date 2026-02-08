<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAccessController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.admin.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $roles = ['admin', 'tu', 'pimpinan', 'staff']; // Sesuaikan role
        return view('users.admin.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,tu,pimpinan,staff',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User baru berhasil ditambahkan');
    }

    /**
     * Form edit hak akses user
     */
    public function edit(User $user)
    {
        $roles = ['admin', 'tu', 'pimpinan', 'staff']; // sesuaikan role
        return view('users.admin.edit', compact('user', 'roles'));
    }

    /**
     * Update hak akses user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,tu,pimpinan,staff',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Hak akses user berhasil diperbarui');
    }

    // Hapus user
    public function destroy(User $user)
    {
        // Opsional: cek agar admin tidak bisa hapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus user sendiri');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
