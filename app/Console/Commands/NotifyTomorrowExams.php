<?php

namespace App\Console\Commands;

use App\Models\Exam;
use App\Services\FcmService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Artisan Command: NotifyTomorrowExams
 * 
 * Mengirimkan push notification FCM ke seluruh siswa yang memiliki ujian besok.
 * 
 * Cara jalankan manual:
 *   php artisan exams:notify-tomorrow
 * 
 * Dijadwalkan otomatis setiap hari pukul 18:00 WIT (11:00 UTC) via console.php
 */
class NotifyTomorrowExams extends Command
{
    protected $signature   = 'exams:notify-tomorrow {--dry-run : Jalankan tanpa mengirim notifikasi (preview saja)}';
    protected $description = 'Kirim push notification FCM ke siswa yang memiliki jadwal ujian besok';

    public function __construct(protected FcmService $fcm)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $isDryRun  = $this->option('dry-run');
        $tomorrow  = Carbon::tomorrow()->format('Y-m-d');
        $dayName   = Carbon::tomorrow()->locale('id')->isoFormat('dddd, D MMMM Y');

        $this->info("🔍 Mencari ujian pada tanggal: {$dayName}");

        // Ambil semua ujian besok yang belum diarsipkan, beserta relasi kelas & mapel
        $exams = Exam::with(['schoolClass.students' => function ($q) {
                        $q->whereNotNull('fcm_token')->where('fcm_token', '!=', '');
                    }, 'subject'])
                    ->whereDate('start_time', $tomorrow)
                    ->where('is_archived', false)
                    ->where('status', '!=', 'cancelled')
                    ->get();

        if ($exams->isEmpty()) {
            $this->info('✅ Tidak ada ujian besok. Tidak ada notifikasi yang dikirim.');
            return Command::SUCCESS;
        }

        $this->info("📋 Ditemukan {$exams->count()} ujian besok:");
        $this->newLine();

        $totalSent   = 0;
        $totalFailed = 0;

        foreach ($exams as $exam) {
            $className   = $exam->schoolClass->name ?? 'Kelas Tidak Diketahui';
            $subjectName = $exam->subject->name ?? 'Mata Pelajaran';
            $startTime   = Carbon::parse($exam->start_time)->format('H:i');
            $endTime     = Carbon::parse($exam->end_time)->format('H:i');
            $students    = $exam->schoolClass->students ?? collect();

            $title = "📝 Ujian {$subjectName} Besok!";
            $body  = "Halo! Kamu ada Ujian {$subjectName} besok, {$dayName} pukul {$startTime} - {$endTime} WIT. Jangan lupa belajar ya! 💪";

            $data = [
                'type'       => 'exam_reminder',
                'exam_id'    => (string) $exam->id,
                'subject'    => $subjectName,
                'class'      => $className,
                'start_time' => $exam->start_time,
                'end_time'   => $exam->end_time,
            ];

            $this->line("  📌 <fg=yellow>{$subjectName}</> — {$className} — {$startTime} WIT");
            $this->line("     Siswa punya token: {$students->count()} orang");

            if ($isDryRun) {
                $this->line('     <fg=cyan>[DRY RUN] Tidak mengirim notifikasi.</> ');
                $this->newLine();
                continue;
            }

            if ($students->isEmpty()) {
                $this->line('     <fg=gray>Tidak ada siswa dengan FCM token aktif, dilewati.</>');
                $this->newLine();
                continue;
            }

            $tokens = $students->pluck('fcm_token')->filter()->values()->toArray();
            $result = $this->fcm->sendToMultiple($tokens, $title, $body, $data);

            $totalSent   += $result['success'];
            $totalFailed += $result['failed'];

            $this->line("     ✅ Terkirim: {$result['success']} | ❌ Gagal: {$result['failed']}");
            if (!empty($result['errors'])) {
                foreach ($result['errors'] as $err) {
                    $this->line("     <fg=red>⚠️ Error: {$err}</>");
                }
            }
            $this->newLine();
        }

        if (!$isDryRun) {
            $summary = "Notifikasi ujian besok selesai. Total terkirim: {$totalSent}, gagal: {$totalFailed}";
            Log::info('[FCM] ' . $summary);
            $this->info("🎉 Selesai! {$summary}");
        }

        return Command::SUCCESS;
    }
    // batas suci
}
