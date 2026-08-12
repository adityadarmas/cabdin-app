<?php

namespace App\Notifications;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Pengajuan $pengajuan,
        private readonly string $message,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'notification_type' => 'status_pengumpulan_data',
            'title' => 'Pembaruan pengumpulan data',
            'message' => $this->message,
            'pengajuan_id' => $this->pengajuan->id,
            'jenis_pengajuan' => $this->pengajuan->jenisPengajuan?->nama ?? $this->pengajuan->judul,
            'url' => route('operator.pengajuan.show', $this->pengajuan),
        ];
    }
}
