<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;

class PruneReadNotifications extends Command
{
    protected $signature = 'notifications:prune {--days=90 : Hapus notifikasi yang sudah dibaca lebih dari jumlah hari ini} {--dry-run : Tampilkan jumlah tanpa menghapus data}';

    protected $description = 'Hapus notifikasi database yang sudah dibaca dan kedaluwarsa';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days < 1) {
            $this->error('Nilai --days harus minimal 1.');

            return self::FAILURE;
        }

        $query = DatabaseNotification::query()
            ->whereNotNull('read_at')
            ->where('read_at', '<', now()->subDays($days));

        $count = $query->count();

        if ($this->option('dry-run')) {
            $this->info("{$count} notifikasi yang sudah dibaca akan dihapus.");

            return self::SUCCESS;
        }

        $query->delete();
        $this->info("{$count} notifikasi yang sudah dibaca telah dihapus.");

        return self::SUCCESS;
    }
}
