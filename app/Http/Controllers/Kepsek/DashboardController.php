<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPI Metrik Utama
        $totalSiswa = User::activeStudents()->count();
        $totalGuru  = User::where('role', 'teacher')->count();
        $totalKelas = SchoolClass::count();
        $totalMapel = Subject::count();
        $totalUjian = Exam::active()->count();

        // 2. Statistik Nilai Keseluruhan
        $avgScore = ExamSession::whereNotNull('score')->avg('score') ?? 0;
        $totalSessions = ExamSession::count();
        $totalCompleted = ExamSession::whereNotNull('end_time')->count();

        // 3. Analisis Nilai Rata-rata per Mata Pelajaran
        $mapelScores = Subject::with(['exams.sessions' => function($q) {
                $q->whereNotNull('score');
            }])
            ->get()
            ->map(function ($subject) {
                $scores = $subject->exams->flatMap(function($exam) {
                    return $exam->sessions->pluck('score');
                });
                return [
                    'name' => $subject->name,
                    'avg'  => $scores->count() > 0 ? round($scores->avg(), 1) : 0,
                    'count'=> $scores->count(),
                ];
            })
            ->filter(fn($item) => $item['count'] > 0 || true)
            ->take(8);

        // 4. Analisis Ketuntasan Nilai Siswa (KKM = 75)
        $tuntasCount = ExamSession::whereNotNull('score')->where('score', '>=', 75)->count();
        $belumTuntasCount = ExamSession::whereNotNull('score')->where('score', '<', 75)->count();

        // 5. Analisis Integritas CBT (Normal vs Terdeteksi Pelanggaran/Ganti Tab)
        $detectedCount = ExamSession::where('is_detected', true)->count();
        $normalCount   = max(0, $totalSessions - $detectedCount);

        // 6. Tren Partisipasi per Ujian Terakhir
        $recentExams = Exam::with(['schoolClass', 'subject'])
            ->withCount(['sessions as total_peserta'])
            ->withCount(['sessions as selesai_peserta' => function($q) {
                $q->whereNotNull('end_time');
            }])
            ->active()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('kepsek.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalUjian',
            'avgScore',
            'totalSessions',
            'totalCompleted',
            'mapelScores',
            'tuntasCount',
            'belumTuntasCount',
            'detectedCount',
            'normalCount',
            'recentExams'
        ));
    }
}
