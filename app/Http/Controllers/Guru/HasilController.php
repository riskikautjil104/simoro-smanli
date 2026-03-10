<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\ExamSession;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil subject milik guru
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        // Ambil exam milik guru
        $examIds = Exam::whereIn('subject_id', $subjectIds)->pluck('id');

        // Ambil hasil ujian untuk exam milik guru dari ExamSession
        // Load relasi exam (dengan subject dan class), dan user (siswa)
        $results = ExamSession::with([
            'exam' => function ($q) {
                $q->with(['subject', 'schoolClass']);
            },
            'user'
        ])
            ->whereIn('exam_id', $examIds)
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'score' => $session->score,
                    'status' => $session->end_time ? 'Selesai' : 'Sedang Berlangsung',
                    'student' => $session->user ? [
                        'id' => $session->user->id,
                        'name' => $session->user->name,
                        'ttd_signature' => $session->user->ttd_signature,
                    ] : null,
                    'exam' => $session->exam ? [
                        'id' => $session->exam->id,
                        'title' => $session->exam->title,
                        'subject' => $session->exam->subject ? [
                            'id' => $session->exam->subject->id,
                            'name' => $session->exam->subject->name,
                        ] : null,
                        'school_class' => $session->exam->schoolClass ? [
                            'id' => $session->exam->schoolClass->id,
                            'name' => $session->exam->schoolClass->name,
                        ] : null,
                    ] : null,
                ];
            });

        // Sertakan ttd guru
        return response()->json([
            'results' => $results,
            'guru_ttd' => $user->ttd_signature,
        ]);
    }
}
