<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class OperatorNotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = $user->unreadNotifications()->whereIn('data->notification_type', ['status_pengumpulan_data', 'tagihan_baru']);
        $notifications = (clone $query)->latest()->paginate(20);
        $query->update(['read_at' => now()]);

        return view('operator.notifikasi.index', compact('notifications'));
    }

    public function feed(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'unread_count' => $user->unreadNotifications()->whereIn('data->notification_type', ['status_pengumpulan_data', 'tagihan_baru'])->count(),
            'notifications' => $user->unreadNotifications()->whereIn('data->notification_type', ['status_pengumpulan_data', 'tagihan_baru'])->latest()->limit(10)->get()
                ->map(fn ($notification) => [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notifikasi',
                    'message' => $notification->data['message'] ?? '',
                    'url' => $notification->data['url'] ?? route('operator.pengajuan.index'),
                ])->values(),
        ]);
    }
}
