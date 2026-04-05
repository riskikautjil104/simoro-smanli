<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Exam;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalSiswa = User::where('role', 'student')->count();
        $totalGuru = User::where('role', 'teacher')->count();
        $totalKelas = SchoolClass::count();
        $totalMapel = Subject::count();
        $totalUjian = Exam::count();
        $totalPeserta = \App\Models\ExamSession::count();
        // Bisa tambahkan statistik lain jika perlu
        return response()->json([
            'total_siswa' => $totalSiswa,
            'total_guru' => $totalGuru,
            'total_kelas' => $totalKelas,
            'total_mapel' => $totalMapel,
            'total_ujian' => $totalUjian,
            'total_peserta' => $totalPeserta,
        ]);
    }
    public function chart()
    {
        // Ujian per bulan (6 bulan terakhir)
        $labels = [];
        $ujianData = [];
        $pesertaData = [];
        $nilaiLabels = ['A', 'B', 'C', 'D', 'E'];
        $nilaiData = [0, 0, 0, 0, 0];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i)->format('M Y');
            $labels[] = $bulan;
            $ujianData[] = \App\Models\Exam::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->count();
            $pesertaData[] = \App\Models\ExamSession::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->count();
        }
        // Nilai distribusi (A=85+, B=70-84, C=55-69, D=40-54, E<40)
        $nilaiA = \App\Models\ExamSession::where('score', '>=', 85)->count();
        $nilaiB = \App\Models\ExamSession::where('score', '>=', 70)->where('score', '<', 85)->count();
        $nilaiC = \App\Models\ExamSession::where('score', '>=', 55)->where('score', '<', 70)->count();
        $nilaiD = \App\Models\ExamSession::where('score', '>=', 40)->where('score', '<', 55)->count();
        $nilaiE = \App\Models\ExamSession::where('score', '<', 40)->count();
        $nilaiData = [$nilaiA, $nilaiB, $nilaiC, $nilaiD, $nilaiE];
        return response()->json([
            'ujian' => ['labels' => $labels, 'data' => $ujianData],
            'peserta' => ['labels' => $labels, 'data' => $pesertaData],
            'laporan' => ['labels' => $nilaiLabels, 'data' => $nilaiData],
        ]);
    }
}
