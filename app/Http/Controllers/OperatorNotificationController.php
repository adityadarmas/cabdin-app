<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class OperatorNotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate(20);
        $user->unreadNotifications()->update(['read_at' => now()]);

        return view('operator.notifikasi.index', compact('notifications'));
    }

    public function feed(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
            'notifications' => $user->unreadNotifications()->latest()->limit(10)->get()
                ->map(fn ($notification) => [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notifikasi',
                    'message' => $notification->data['message'] ?? '',
                    'url' => $notification->data['url'] ?? route('operator.pengajuan.index'),
                ])->values(),
        ]);
    }
}
