<?php

namespace App\Notifications;

use App\Models\Berita;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BeritaPublished extends Notification
{
    use Queueable;

    public function __construct(private readonly Berita $berita)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Berita baru',
            'message' => "Berita baru telah diterbitkan: {$this->berita->judul}",
            'berita_id' => $this->berita->id,
            'url' => route('berita.show', $this->berita),
        ];
    }
}
