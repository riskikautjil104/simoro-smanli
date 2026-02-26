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
        $mapel = Subject::where('teacher_id', $user->id)->count();
        $soal = Question::whereHas('exam', function ($q) use ($user) {
            $q->where('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'));
        })->count();
        $ujian = Exam::where('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'))->count();
        $hasil = ExamSession::whereIn('exam_id', Exam::where('subject_id', Subject::where('teacher_id', $user->id)->pluck('id'))->pluck('id'))->count();
        return response()->json([
            'mapel' => $mapel,
            'soal' => $soal,
            'ujian' => $ujian,
            'hasil' => $hasil,
        ]);
    }
}
