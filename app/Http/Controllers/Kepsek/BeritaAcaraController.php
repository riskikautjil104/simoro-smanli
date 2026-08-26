<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BeritaAcaraExport;

class BeritaAcaraController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subject.teacher', 'schoolClass'])
            ->active()
            ->orderBy('start_time', 'desc')
            ->get();

        return view('kepsek.berita_acara', compact('exams'));
    }

    public function show($examId)
    {
        $exam = Exam::with(['subject.teacher', 'schoolClass'])->findOrFail($examId);

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
                    'is_detected'=> $s->is_detected,
                ];
            });

        $totalPeserta = $sessions->count();
        $totalSelesai = $sessions->where('status', 'Selesai')->count();
        $totalBelum   = $totalPeserta - $totalSelesai;

        return view('guru.berita-acara.show', compact(
            'exam', 'sessions', 'totalPeserta', 'totalSelesai', 'totalBelum'
        ));
    }

    public function exportPdf($examId)
    {
        $exam = Exam::with(['subject.teacher', 'schoolClass'])->findOrFail($examId);

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

        $guru = $exam->subject ? $exam->subject->teacher : null;
        $kepsek = auth()->user();

        $pdf = Pdf::loadView('guru.berita-acara.pdf', compact('exam', 'sessions', 'guru', 'kepsek'))
            ->setPaper('a4', 'portrait');

        $filename = 'Berita_Acara_' . str_replace(' ', '_', $exam->title) . '_' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}
