<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\Subject;
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
        $results = \App\Models\ExamSession::with(['exam.subject', 'exam.schoolClass', 'user as student'])
            ->whereIn('exam_id', $examIds)
            ->get();
        // Sertakan ttd guru
        return response()->json([
            'results' => $results,
            'guru_ttd' => $user->ttd_signature,
        ]);
    }
}
