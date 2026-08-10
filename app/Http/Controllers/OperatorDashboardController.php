<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $notifikasi = auth()->user()->notifications()->latest()->limit(8)->get();
        $pengumumans = Pengumuman::where('is_active', true)
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->latest('published_at')
            ->limit(8)
            ->get();

        return view('operator.dashboard', compact('notifikasi', 'pengumumans'));
    }
}
