<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RankingController extends Controller
{
    /**
     * Halaman utama ranking - list ujian aktif
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $sevenDaysAgo = $now->copy()->subDays(7);

        $exams = Exam::with(['subject', 'schoolClass'])
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $sevenDaysAgo)
            ->orderByDesc('end_time')
            ->get();

        $activeExams = $exams
            ->map(function ($exam) {
                try {
                    return [
                        'id' => $exam->id,
                        'title' => $exam->title,
                        'subject' => $exam->subject?->name ?? '-',
                        'class' => $exam->schoolClass?->name ?? '-',
                        'end_time' => $exam->end_time?->format('d M Y, H:i') ?? '-',
                        'has_ranking' => false,
                    ];
                } catch (\Exception $e) {
                    Log::error('Error mapping exam ' . $exam->id . ': ' . $e->getMessage());
                    return null;
                }
            })
            ->filter()
            ->values();

        return view('frontend.ranking', compact('activeExams'));
    }

    /**
     * Ranking detail untuk ujian tertentu
     * GET /ranking/{id} → view
     * GET /ranking/{id} + Accept:application/json → JSON data
     */
    public function show($id)
    {
        $exam = Exam::with(['subject', 'schoolClass'])->findOrFail($id);

        if (request()->wantsJson() || request()->expectsJson()) {
            $ranking = ExamSession::where('exam_id', $id)
                ->whereNotNull('score') // Hanya yang sudah ada nilai
                ->join('users', 'exam_sessions.user_id', '=', 'users.id')
                ->leftJoin('classes', 'users.class_id', '=', 'classes.id')
                ->select(
                    'exam_sessions.user_id',
                    'exam_sessions.score as nilai',
                    'users.name',
                    'classes.name as kelas'
                )
                ->orderByDesc('nilai')
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => $row->user_id,
                        'nama' => $row->name ?? 'Anonim',
                        'kelas' => $row->kelas ?? '-',
                        'nilai' => round((float) $row->nilai, 1),
                    ];
                })
                ->values(); // Reset keys untuk JS

            return response()->json($ranking);
        }

        return view('frontend.ranking-show', compact('exam'));
    }
}
