<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class HasilFilterController extends Controller
{
    public function filters(Request $request)
    {
        $user = $request->user();
        $subjects = Subject::where('teacher_id', $user->id)->get();
        $exams = Exam::with(['subject', 'schoolClass'])
            ->whereIn('subject_id', $subjects->pluck('id'))
            ->get();
        return response()->json([
            'subjects' => $subjects,
            'exams' => $exams,
        ]);
    }
}
