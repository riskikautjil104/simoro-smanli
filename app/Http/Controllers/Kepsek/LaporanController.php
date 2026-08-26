<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::active()->orderBy('title')->get();
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('kepsek.laporan', compact('exams', 'classes', 'subjects'));
    }

    public function data(Request $request)
    {
        $query = ExamSession::with(['user.class', 'exam.subject']);

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }
        if ($request->filled('class_id')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }
        if ($request->filled('subject_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        $results = $query->orderBy('score', 'desc')->get()->map(function($s, $idx) {
            return [
                'no' => $idx + 1,
                'nama' => $s->user ? $s->user->name : '-',
                'nis' => $s->user ? ($s->user->nis ?? '-') : '-',
                'kelas' => $s->user && $s->user->class ? $s->user->class->name : '-',
                'ujian' => $s->exam ? $s->exam->title : '-',
                'mapel' => $s->exam && $s->exam->subject ? $s->exam->subject->name : '-',
                'nilai' => $s->score !== null ? number_format((float)$s->score, 1) : '-',
                'status' => $s->end_time ? 'Selesai' : 'Belum Selesai',
                'mulai' => $s->start_time ? $s->start_time->format('d/m H:i') : '-',
                'selesai' => $s->end_time ? $s->end_time->format('d/m H:i') : '-',
            ];
        });

        return response()->json($results);
    }
}
