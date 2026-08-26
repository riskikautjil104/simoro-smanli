<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BeritaAcaraExport;

class BeritaAcaraController extends Controller
{
    /**
     * Halaman daftar ujian guru untuk pilih berita acara.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $exams = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjectIds)
            ->active()
            ->orderBy('start_time', 'desc')
            ->get();

        return view('guru.berita-acara.index', compact('exams'));
    }

    /**
     * Detail berita acara 1 ujian: daftar absensi peserta yang hadir/selesai.
     */
    public function show(Request $request, $examId)
    {
        $user = $request->user();
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $exam = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjectIds)
            ->findOrFail($examId);

        // Ambil peserta (ExamSession) berikut data user dan waktu pengerjaan
        $sessions = ExamSession::with('user')
            ->where('exam_id', $examId)
            ->orderBy('start_time')
            ->get()
            ->map(function ($s, $idx) {
                return [
                    'no'         => $idx + 1,
                    'user_id'    => $s->user_id,
                    'nama'       => $s->user ? $s->user->name : '-',
                    'nis'        => $s->user ? ($s->user->nis ?? '-') : '-',
                    'start_time' => $s->start_time,
                    'end_time'   => $s->end_time,
                    'status'     => $s->end_time ? 'Selesai' : 'Belum Selesai',
                    'score'      => $s->score ?? '-',
                    'ip_address' => $s->ip_address ?? '-',
                    'is_detected'=> $s->is_detected,
                ];
            });

        $totalPeserta  = $sessions->count();
        $totalSelesai  = $sessions->where('status', 'Selesai')->count();
        $totalBelum    = $totalPeserta - $totalSelesai;

        if ($request->expectsJson()) {
            return response()->json([
                'exam'          => $exam,
                'sessions'      => $sessions->values(),
                'total_peserta' => $totalPeserta,
                'total_selesai' => $totalSelesai,
                'total_belum'   => $totalBelum,
            ]);
        }

        return view('guru.berita-acara.show', compact(
            'exam', 'sessions', 'totalPeserta', 'totalSelesai', 'totalBelum'
        ));
    }

    /**
     * Export PDF Berita Acara Ujian.
     */
    public function exportPdf(Request $request, $examId)
    {
        $user = $request->user();
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $exam = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjectIds)
            ->findOrFail($examId);

        $sessions = ExamSession::with('user')
            ->where('exam_id', $examId)
            ->orderBy('start_time')
            ->get()
            ->map(function ($s, $idx) {
                return [
                    'no'         => $idx + 1,
                    'nama'       => $s->user ? $s->user->name : '-',
                    'nis'        => $s->user ? ($s->user->nis ?? '-') : '-',
                    'start_time' => $s->start_time ? $s->start_time->format('H:i:s') : '-',
                    'end_time'   => $s->end_time   ? $s->end_time->format('H:i:s')   : '-',
                    'status'     => $s->end_time ? 'Selesai' : 'Belum Selesai',
                    'score'      => $s->score ?? '-',
                    'keterangan' => $s->is_detected ? '⚠ Terdeteksi' : '',
                ];
            });

        $guru = $user;
        $kepsek = \App\Models\User::where('role', 'kepala_sekolah')->first();
        $pdf  = Pdf::loadView('guru.berita-acara.pdf', compact('exam', 'sessions', 'guru', 'kepsek'))
            ->setPaper('a4', 'portrait');

        $filename = 'Berita_Acara_' . str_replace(' ', '_', $exam->title) . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export Excel Berita Acara Ujian.
     */
    public function exportExcel(Request $request, $examId)
    {
        $user = $request->user();
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $exam = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjectIds)
            ->findOrFail($examId);

        $sessions = ExamSession::with('user')
            ->where('exam_id', $examId)
            ->orderBy('start_time')
            ->get()
            ->map(function ($s, $idx) {
                return [
                    'No'               => $idx + 1,
                    'Nama Siswa'       => $s->user ? $s->user->name : '-',
                    'NIS'              => $s->user ? ($s->user->nis ?? '-') : '-',
                    'Waktu Mulai'      => $s->start_time ? $s->start_time->format('d-m-Y H:i:s') : '-',
                    'Waktu Selesai'    => $s->end_time   ? $s->end_time->format('d-m-Y H:i:s')   : '-',
                    'Status Pengerjaan'=> $s->end_time ? 'Selesai' : 'Belum Selesai',
                    'Nilai'            => $s->score ?? '-',
                    'Keterangan'       => $s->is_detected ? 'Terdeteksi Kecurangan' : '',
                ];
            });

        $filename = 'Berita_Acara_' . str_replace(' ', '_', $exam->title) . '_' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new BeritaAcaraExport($sessions->toArray()), $filename);
    }
}
