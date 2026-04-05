<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Exam;
use Illuminate\Http\Request;

class SoalFilterController extends Controller
{
    public function filters(Request $request)
    {
        $user = $request->user();
        // Ambil mapel yang diajar guru
        $subjects = Subject::with('classes')
            ->where('teacher_id', $user->id)
            ->get();
        // Ambil semua ujian yang dibuat guru (berdasarkan subject)
        $exams = Exam::with('subject', 'schoolClass')
            ->whereIn('subject_id', $subjects->pluck('id'))
            ->get();
        return response()->json([
            'subjects' => $subjects,
            'exams' => $exams,
        ]);
    }
}
