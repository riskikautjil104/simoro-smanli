<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // Ambil semua soal yang dibuat oleh guru ini (berdasarkan subject yang diajarkan)
        $questions = Question::with(['subject', 'exam.schoolClass'])
            ->whereHas('subject', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            })
            ->get();
        return response()->json($questions);
    }
}
