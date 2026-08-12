<?php

namespace App\Notifications;

use App\Models\JenisPengajuan;
use Illuminate\Notifications\Notification;

class TagihanBaru extends Notification
{
    public function __construct(private readonly JenisPengajuan $jenisPengajuan) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        return ['notification_type' => 'tagihan_baru', 'title' => 'Tagihan baru', 'message' => "Segera kumpulkan data {$this->jenisPengajuan->nama} sebelum {$this->jenisPengajuan->deadline_at?->translatedFormat('d M Y, H:i')}.", 'url' => route('operator.tagihan.index')];
    }
}
