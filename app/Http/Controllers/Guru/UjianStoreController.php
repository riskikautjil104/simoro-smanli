<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class UjianStoreController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
        ]);
        // Pastikan subject milik guru
        $subject = Subject::where('id', $request->subject_id)->where('teacher_id', $user->id)->firstOrFail();
        // Pastikan kelas valid untuk mapel tsb
        $class = $subject->classes()->where('classes.id', $request->class_id)->firstOrFail();
        $exam = Exam::create([
            'title' => $request->title,
            'subject_id' => $subject->id,
            'class_id' => $class->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'status' => 'draft',
        ]);
        return response()->json(['success' => true, 'exam' => $exam]);
    }
}
