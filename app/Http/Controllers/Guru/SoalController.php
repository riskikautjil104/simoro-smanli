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

        $questions = Question::with(['subject', 'exam.schoolClass'])
            ->whereHas('subject', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            })
            ->get();

        return response()->json($questions);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $question = Question::with(['subject', 'exam.schoolClass'])
            ->whereHas('subject', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            })
            ->findOrFail($id);

        return response()->json($question);
    }

   public function update(Request $request, $id)
{
    $user = $request->user();

    $question = Question::whereHas('subject', function ($q) use ($user) {
            $q->where('teacher_id', $user->id);
        })
        ->findOrFail($id);

    $validated = $request->validate([
        'pertanyaan'    => 'required|string',
        'type'          => 'required|in:pg,essay',
        'type' => 'required|in:multiple_choice,essay',
        'opsi_a'        => 'nullable|string',
        'opsi_b'        => 'nullable|string',
        'opsi_c'        => 'nullable|string',
        'opsi_d'        => 'nullable|string',
        'jawaban_benar' => 'nullable|string',
        'subject_id'    => 'required|exists:subjects,id',
        'exam_id'       => 'required|exists:exams,id',
    ]);

    $question->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Soal berhasil diperbarui.',
        'data'    => $question->load(['subject', 'exam.schoolClass']),
    ]);
}

    public function destroy(Request $request, $id)
{
    $user = $request->user();

    $question = Question::whereHas('subject', function ($q) use ($user) {
            $q->where('teacher_id', $user->id);
        })
        ->findOrFail($id);

    $sudahDijawab = \DB::table('student_answers')->where('question_id', $id)->exists();
    if ($sudahDijawab) {
        return response()->json([
            'success' => false,
            'message' => 'Soal tidak dapat dihapus karena sudah memiliki jawaban siswa.',
        ], 422);
    }

    $question->delete();

    return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus.']);
}
}
