<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.laporan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|numeric',
        ]);
        $result = \App\Models\ExamResult::create($validated);
        return response()->json($result);
    }

    public function show($id)
    {
        $result = \App\Models\ExamResult::findOrFail($id);
        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $result = \App\Models\ExamResult::findOrFail($id);
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|numeric',
        ]);
        $result->update($validated);
        return response()->json($result);
    }

    public function destroy($id)
    {
        $result = \App\Models\ExamResult::findOrFail($id);
        $result->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

   
}
