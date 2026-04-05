<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subject', 'schoolClass'])->get();
        return response()->json($exams);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'duration' => 'nullable|integer|min:0',
        ]);

        $exam = Exam::create($validated);
        return response()->json($exam, 201);
    }

    public function show($id)
    {
        $exam = Exam::with(['subject', 'schoolClass', 'questions'])->findOrFail($id);
        return response()->json($exam);
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'class_id' => 'sometimes|required|exists:classes,id',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'duration' => 'nullable|integer|min:0',
        ]);

        $exam->update($validated);
        return response()->json($exam);
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        
        // Delete related data first
        \App\Models\Question::where('exam_id', $id)->delete();
        \App\Models\StudentAnswer::where('exam_id', $id)->delete();
        \App\Models\ExamSession::where('exam_id', $id)->delete();
        \App\Models\ExamResult::where('exam_id', $id)->delete();
        \App\Models\ExamLog::where('exam_id', $id)->delete();
        
        $exam->delete();
        return response()->json(['success' => true]);
    }
}

