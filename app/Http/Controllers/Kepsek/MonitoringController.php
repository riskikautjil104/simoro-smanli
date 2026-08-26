<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subject', 'schoolClass'])
            ->withCount('sessions')
            ->active()
            ->orderBy('start_time', 'desc')
            ->get();

        return view('kepsek.monitoring', compact('exams'));
    }

    public function data(Request $request)
    {
        $examId = $request->query('exam_id');
        $query = ExamSession::with(['user.class', 'exam.subject']);

        if ($examId) {
            $query->where('exam_id', $examId);
        }

        $sessions = $query->orderBy('updated_at', 'desc')->get()->map(function($s) {
            return [
                'id' => $s->id,
                'nama' => $s->user ? $s->user->name : '-',
                'nis' => $s->user ? ($s->user->nis ?? '-') : '-',
                'kelas' => $s->user && $s->user->class ? $s->user->class->name : '-',
                'ujian' => $s->exam ? $s->exam->title : '-',
                'mapel' => $s->exam && $s->exam->subject ? $s->exam->subject->name : '-',
                'start_time' => $s->start_time ? $s->start_time->format('H:i:s') : '-',
                'end_time' => $s->end_time ? $s->end_time->format('H:i:s') : '-',
                'is_active' => $s->is_active,
                'is_detected' => $s->is_detected,
                'detection_reason' => $s->detection_reason,
                'status' => $s->end_time ? 'Selesai' : ($s->is_active ? 'Sedang Ujian' : 'Offline / Logout'),
                'score' => $s->score,
            ];
        });

        return response()->json($sessions);
    }
}
