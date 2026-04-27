<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses data registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'role'         => 'required|in:admin,staff,tu,pimpinan,operator',
            'nama_sekolah' => 'required_if:role,operator|nullable|string|max:255',
            'no_wa'        => 'required_if:role,operator|nullable|string|max:20',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'         => $request->name,
            'nama_sekolah' => $request->role === 'operator' ? $request->nama_sekolah : null,
            'no_wa'        => $request->role === 'operator' ? $request->no_wa : null,
            'email'        => $request->email,
            'role'         => $request->role,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }
}
