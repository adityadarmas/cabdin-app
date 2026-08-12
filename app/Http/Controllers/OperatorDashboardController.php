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
            ->with(['tagihanKonfirmasis' => fn ($query) => $query->where('user_id', auth()->id())])
            ->withCount(['pengajuans as pengumpulan_operator_count' => fn ($query) => $query->where('user_id', auth()->id())])
            ->orderBy('deadline_at')
            ->get()
            ->each(function (JenisPengajuan $tagihan) {
                $tagihan->sudah_dikumpulkan = $tagihan->pengumpulan_operator_count > 0;
                $tagihan->sudah_dibaca = $tagihan->tagihanKonfirmasis->isNotEmpty();
            });

        return view('operator.dashboard', compact('notifikasi', 'pengumumans', 'tagihans'));
    }
}
