<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Exam;
use App\Models\ExamSession;

class DashboardController extends Controller
{
    public function stats()
    {
        $user = auth()->user();
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $mapel = $subjectIds->count();
        $soal = Question::whereHas('exam', function ($q) use ($subjectIds) {
            $q->whereIn('subject_id', $subjectIds);
        })->count();

        $ujianIds = Exam::whereIn('subject_id', $subjectIds)->pluck('id');
        $ujian = $ujianIds->count();
        $hasil = ExamSession::whereIn('exam_id', $ujianIds)->count();

        return response()->json([
            'mapel' => $mapel,
            'soal' => $soal,
            'ujian' => $ujian,
            'hasil' => $hasil,
        ]);
    }
}
