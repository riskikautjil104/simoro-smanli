<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamSession;
use App\Models\Graduation;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalSiswa       = User::activeStudents()->count();
        $totalLulus       = User::graduatedStudents()->count();
        $totalGuru        = User::where('role', 'teacher')->count();
        $totalKelas       = SchoolClass::count();
        $totalMapel       = Subject::count();
        $totalUjian       = Exam::active()->count();
        $totalUjianArsip  = Exam::archived()->count();
        $totalSoal        = Question::count();
        $totalSoalPg      = Question::where('type', '!=', 'essay')->orWhereNull('type')->count();
        $totalSoalEssay   = Question::where('type', 'essay')->count();
        $totalPeserta     = ExamSession::count();
        $totalSelesai     = ExamSession::whereNotNull('end_time')->count();

        return response()->json([
            'total_siswa'       => $totalSiswa,
            'total_lulus'       => $totalLulus,
            'total_guru'        => $totalGuru,
            'total_kelas'       => $totalKelas,
            'total_mapel'       => $totalMapel,
            'total_ujian'       => $totalUjian,
            'total_ujian_arsip' => $totalUjianArsip,
            'total_soal'        => $totalSoal,
            'total_soal_pg'     => $totalSoalPg,
            'total_soal_essay'  => $totalSoalEssay,
            'total_peserta'     => $totalPeserta,
            'total_selesai'     => $totalSelesai,
        ]);
    }

    public function chart()
    {
        // 1. Ujian & Peserta per bulan (6 bulan terakhir)
        $labels = [];
        $ujianData = [];
        $pesertaData = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i)->format('M Y');
            $labels[] = $bulan;
            $ujianData[] = Exam::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->count();
            $pesertaData[] = ExamSession::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->count();
        }

        // 2. Nilai distribusi (A=85+, B=70-84, C=55-69, D=40-54, E<40)
        $nilaiA = ExamSession::where('score', '>=', 85)->count();
        $nilaiB = ExamSession::where('score', '>=', 70)->where('score', '<', 85)->count();
        $nilaiC = ExamSession::where('score', '>=', 55)->where('score', '<', 70)->count();
        $nilaiD = ExamSession::where('score', '>=', 40)->where('score', '<', 55)->count();
        $nilaiE = ExamSession::where('score', '<', 40)->whereNotNull('score')->count();
        $nilaiLabels = ['A (≥85)', 'B (70-84)', 'C (55-69)', 'D (40-54)', 'E (<40)'];
        $nilaiData = [$nilaiA, $nilaiB, $nilaiC, $nilaiD, $nilaiE];

        // 3. Distribusi Jumlah Siswa per Kelas
        $classes = SchoolClass::withCount(['students' => function($q) {
            $q->where('is_graduated', false);
        }])->orderBy('name')->get();
        $kelasLabels = $classes->pluck('name')->toArray();
        $kelasData   = $classes->pluck('students_count')->toArray();

        // 4. Komposisi Soal (PG vs Essay)
        $soalPg    = Question::where('type', '!=', 'essay')->orWhereNull('type')->count();
        $soalEssay = Question::where('type', 'essay')->count();

        // 5. Rasio Siswa Aktif vs Lulus
        $siswaAktif = User::activeStudents()->count();
        $siswaLulus = User::graduatedStudents()->count();

        return response()->json([
            'ujian'     => ['labels' => $labels, 'data' => $ujianData],
            'peserta'   => ['labels' => $labels, 'data' => $pesertaData],
            'laporan'   => ['labels' => $nilaiLabels, 'data' => $nilaiData],
            'kelas'     => ['labels' => $kelasLabels, 'data' => $kelasData],
            'soal'      => ['labels' => ['Pilihan Ganda', 'Essay / Uraian'], 'data' => [$soalPg, $soalEssay]],
            'kelulusan' => ['labels' => ['Siswa Aktif', 'Siswa Lulus / Alumni'], 'data' => [$siswaAktif, $siswaLulus]],
        ]);
    }
}
