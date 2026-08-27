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

// Kirim notifikasi ujian besok ke siswa setiap hari pukul 18:00 WIT
Schedule::command('exams:notify-tomorrow')
    ->timezone('Asia/Jayapura')
    ->dailyAt('18:00')  // 18:00 WIT (UTC+9)
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/fcm-notifications.log'));

// batas suci
