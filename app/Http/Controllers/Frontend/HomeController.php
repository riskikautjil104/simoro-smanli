<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ExamSession;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik utama
        $stats = [
            'total_siswa' => User::where('role', 'student')->count(),
            'total_guru' => User::where('role', 'teacher')->count(),
            'total_kelas' => SchoolClass::count(),
            'total_mapel' => Subject::count(),
            'total_ujian' => Exam::count(),
            'total_peserta' => ExamSession::count(),
        ];

        // Ujian terbaru (ambil 3 ujian terakhir)
        $recentExams = Exam::with('subject', 'schoolClass')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Ujian yang sedang aktif
        $activeExams = Exam::with('subject', 'schoolClass')
            ->where('status', 'active')
            ->orderBy('start_time', 'desc')
            ->take(3)
            ->get();

        return view('frontend.welcome', compact('stats', 'recentExams', 'activeExams'));
    }
}
