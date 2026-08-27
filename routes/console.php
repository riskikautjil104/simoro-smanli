<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Commands - MORO⁵SMART SIMORO
|--------------------------------------------------------------------------
|
| Seluruh jadwal otomatis server SIMORO SMA Negeri 5 Kabupaten Pulau Morotai
|
*/

// Kirim notifikasi ujian besok ke siswa setiap hari pukul 18:00 WIT (= 09:00 UTC)
// Menggunakan UTC karena server biasanya menggunakan timezone UTC
Schedule::command('exams:notify-tomorrow')
    ->dailyAt('09:00')  // 09:00 UTC = 18:00 WIT (UTC+9)
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/fcm-notifications.log'));
