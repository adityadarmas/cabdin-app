<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect berdasarkan role
        $role = auth()->user()->role;

        if (auth()->user()->role === 'admin') {
        return redirect()->route('dashboard.index');
        }

        // MENGGUNAKAN POLICY (TANPA URI KE ROLE)
        return redirect()->route('surat-masuk.index');


        // Fallback kalau role tidak dikenal
        return redirect()->intended('/home');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
