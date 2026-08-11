<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\JenisPengajuan;

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifikasi = $user->unreadNotifications()->latest()->limit(8)->get();
        $user->unreadNotifications()->update(['read_at' => now()]);
        $pengumumans = Pengumuman::where('is_active', true)
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->latest('published_at')
            ->limit(8)
            ->get();
        $tagihans = JenisPengajuan::where('is_active', true)
            ->where('is_tagihan_dashboard', true)
            ->where('deadline_at', '>=', now())
            ->orderBy('deadline_at')->get();

        return view('operator.dashboard', compact('notifikasi', 'pengumumans', 'tagihans'));
    }
}
