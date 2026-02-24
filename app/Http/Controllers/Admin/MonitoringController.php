<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.monitoring');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'exam_id' => 'required|exists:exams,id',
            'activity' => 'required|string',
        ]);
        $log = \App\Models\ExamLog::create($validated);
        return response()->json($log);
    }
    // Endpoint data monitoring ujian (AJAX)
    public function data()
    {
        try {
            $ujians = \App\Models\Exam::with(['schoolClass', 'subject'])->get();
            $result = $ujians->map(function ($ujian) {
                $kelas = $ujian->schoolClass && isset($ujian->schoolClass->name) ? $ujian->schoolClass->name : '-';
                $mapel = $ujian->subject && isset($ujian->subject->name) ? $ujian->subject->name : '-';
                $peserta = \App\Models\ExamSession::where('exam_id', $ujian->id)->count();
                $selesai = \App\Models\ExamSession::where('exam_id', $ujian->id)
                    ->whereNotNull('end_time')->count();
                $status = $peserta === 0 ? 'Belum Dimulai' : ($selesai === $peserta ? 'Selesai' : 'Sedang Berlangsung');
                return [
                    'id' => $ujian->id,
                    'nama' => $ujian->title,
                    'kelas' => $kelas,
                    'mapel' => $mapel,
                    'jumlah_peserta' => $peserta,
                    'peserta_selesai' => $selesai,
                    'status' => $status,
                ];
            });
            return response()->json($result->values());
        } catch (\Exception $e) {
            \Log::error('Monitoring error: ' . $e->getMessage());
            return response()->json([]);
        }
    }
    public function show($id)
    {
        $log = \App\Models\ExamLog::findOrFail($id);
        return response()->json($log);
    }

    public function update(Request $request, $id)
    {
        $log = \App\Models\ExamLog::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'exam_id' => 'required|exists:exams,id',
            'activity' => 'required|string',
        ]);
        $log->update($validated);
        return response()->json($log);
    }

    public function destroy($id)
    {
        $log = \App\Models\ExamLog::findOrFail($id);
        $log->delete();
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
