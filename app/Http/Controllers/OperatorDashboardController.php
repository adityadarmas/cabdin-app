<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\JenisPengajuan;
use App\Models\Panduan;

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notificationQuery = $user->unreadNotifications()->whereIn('data->notification_type', ['status_pengumpulan_data', 'tagihan_baru']);
        $notifikasi = (clone $notificationQuery)->latest()->limit(8)->get();
        $notificationQuery->update(['read_at' => now()]);
        $pengumumans = Pengumuman::where('is_active', true)
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->latest('published_at')
            ->limit(8)
            ->get();
        $panduans = Panduan::where('is_active', true)->orderBy('urutan')->latest()->limit(6)->get();
        $tagihans = JenisPengajuan::where('is_active', true)
            ->where('is_tagihan_dashboard', true)
            ->where('deadline_at', '>=', now())
            ->where(fn ($query) => $query->where('target_bentuk_pendidikan', 'semua')->orWhere('target_bentuk_pendidikan', $user->bentuk_pendidikan))
            ->where(fn ($query) => $query->where('target_status_sekolah', 'semua')->orWhere('target_status_sekolah', $user->status_sekolah))
            ->with(['tagihanKonfirmasis' => fn ($query) => $query->where('user_id', auth()->id())])
            ->withCount(['pengajuans as pengumpulan_operator_count' => fn ($query) => $query->where('user_id', auth()->id())])
            ->orderBy('deadline_at')
            ->get()
            ->each(function (JenisPengajuan $tagihan) {
                $tagihan->sudah_dikumpulkan = $tagihan->pengumpulan_operator_count > 0;
                $tagihan->sudah_dibaca = $tagihan->tagihanKonfirmasis->isNotEmpty();
            });

        return view('operator.dashboard', compact('notifikasi', 'pengumumans', 'tagihans', 'panduans'));
    }
}
