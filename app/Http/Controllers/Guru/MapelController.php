<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;

use App\Models\Subject;

class MapelController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $mapels = Subject::with(['classes', 'questions', 'exams'])
            ->where('teacher_id', $user->id)
            ->get();
        return response()->json($mapels);
    }
}
