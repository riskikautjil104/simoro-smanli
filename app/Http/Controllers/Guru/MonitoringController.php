<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guru.monitoring');
    }

    /**
     * Endpoint data monitoring ujian (AJAX)
     */
    public function data(Request $request)
    {
        $user = $request->user();

        // Ambil subjectIds guru (jika kosong, tetap bisa akses untuk debugging)
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        // Cek apakah ini mode debug (subjectIds kosong tapi tetap boleh akses)
        $allowAll = $subjectIds->isEmpty();

        // Ambil ujian berdasarkan subject guru
        $query = Exam::with(['subject', 'schoolClass']);

        if (!$allowAll) {
            $query->whereIn('subject_id', $subjectIds);
        }

        $ujians = $query->get();

        $result = $ujians->map(function ($ujian) {
            $kelas = $ujian->schoolClass && isset($ujian->schoolClass->name) ? $ujian->schoolClass->name : '-';
            $mapel = $ujian->subject && isset($ujian->subject->name) ? $ujian->subject->name : '-';

            $peserta = \App\Models\ExamSession::where('exam_id', $ujian->id)->count();
            $selesai = \App\Models\ExamSession::where('exam_id', $ujian->id)
                ->whereNotNull('end_time')->count();

            // Tentukan status
            $status = 'Belum Mulai';
            if ($peserta > 0 && $selesai < $peserta) {
                $status = 'Sedang Berlangsung';
            } else if ($peserta > 0 && $selesai >= $peserta) {
                $status = 'Selesai';
            }

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
    }
}
