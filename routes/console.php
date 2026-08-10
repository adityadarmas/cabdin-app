<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Aman untuk audit: hanya notifikasi yang telah dibaca dan berumur lebih dari
// 90 hari yang dibersihkan. Pengajuan tidak pernah dihapus oleh tugas ini.
Schedule::command('notifications:prune --days=90')->dailyAt('02:15');
