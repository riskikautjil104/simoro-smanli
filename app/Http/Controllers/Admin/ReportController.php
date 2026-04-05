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
    // Endpoint laporan rekap hasil ujian
    public function data(Request $request)
    {
        $ujianId = $request->input('ujian_id');
        $kelasId = $request->input('kelas_id');
        $query = \App\Models\ExamSession::with(['user', 'exam']);
        if ($ujianId) $query->where('exam_id', $ujianId);
        if ($kelasId) $query->whereHas('user', function ($q) use ($kelasId) {
            $q->where('class_id', $kelasId);
        });
        $sessions = $query->get();
        $result = $sessions->map(function ($s) {
            $score = $s->score;
            if ($score > 100) $score = 100;
            return [
                'nama' => $s->user ? $s->user->name : '-',
                'kelas' => $s->user && $s->user->class ? $s->user->class->name : '-',
                'ujian' => $s->exam ? $s->exam->title : '-',
                'nilai' => $score,
                'mulai' => $s->start_time,
                'selesai' => $s->end_time,
                'durasi' => $s->start_time && $s->end_time ? (\Carbon\Carbon::parse($s->start_time)->diffInMinutes($s->end_time) . ' menit') : '-',
            ];
        });
        // Statistik
        $stat = [
            'jumlah_peserta' => $sessions->count(),
            'rata_rata' => $sessions->avg('score'),
            'nilai_tertinggi' => $sessions->max('score'),
            'nilai_terendah' => $sessions->min('score'),
        ];
        return response()->json(['data' => $result, 'statistik' => $stat]);
    }
    // Export Excel
    public function exportExcel(Request $request)
    {
        $ujianId = $request->input('ujian_id');
        $kelasId = $request->input('kelas_id');
        $query = \App\Models\ExamSession::with(['user', 'exam']);
        if ($ujianId) $query->where('exam_id', $ujianId);
        if ($kelasId) $query->whereHas('user', function ($q) use ($kelasId) {
            $q->where('class_id', $kelasId);
        });
        $sessions = $query->get();
        $data = $sessions->map(function ($s) {
            $score = $s->score;
            if ($score > 100) $score = 100;
            return [
                'Nama Siswa' => $s->user ? $s->user->name : '-',
                'Kelas' => $s->user && $s->user->class ? $s->user->class->name : '-',
                'Ujian' => $s->exam ? $s->exam->title : '-',
                'Nilai' => $score,
                'Mulai' => $s->start_time,
                'Selesai' => $s->end_time,
                'Durasi' => $s->start_time && $s->end_time ? (\Carbon\Carbon::parse($s->start_time)->diffInMinutes($s->end_time) . ' menit') : '-',
            ];
        });
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanExport($data), 'laporan_ujian.xlsx');
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $ujianId = $request->input('ujian_id');
        $kelasId = $request->input('kelas_id');
        $query = \App\Models\ExamSession::with(['user', 'exam']);
        if ($ujianId) $query->where('exam_id', $ujianId);
        if ($kelasId) $query->whereHas('user', function ($q) use ($kelasId) {
            $q->where('class_id', $kelasId);
        });
        $ttd = $request->input('ttd');
        $sessions = $query->get();
        $data = $sessions->map(function ($s) {
            $score = $s->score;
            if ($score > 100) $score = 100;
            return [
                'nama' => $s->user ? $s->user->name : '-',
                'kelas' => $s->user && $s->user->class ? $s->user->class->name : '-',
                'ujian' => $s->exam ? $s->exam->title : '-',
                'nilai' => $score,
                'mulai' => $s->start_time,
                'selesai' => $s->end_time,
                'durasi' => $s->start_time && $s->end_time ? (\Carbon\Carbon::parse($s->start_time)->diffInMinutes($s->end_time) . ' menit') : '-',
            ];
        });
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan_pdf', ['data' => $data, 'ttd' => $ttd]);
        return $pdf->download('laporan_ujian.pdf');
    }
    // Rekap rata-rata nilai per siswa
    public function rekapSiswa(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $query = \App\Models\ExamSession::with(['user', 'exam']);
        if ($kelasId) $query->whereHas('user', function ($q) use ($kelasId) {
            $q->where('class_id', $kelasId);
        });
        $sessions = $query->get();
        $rekap = $sessions->groupBy('user_id')->map(function ($items, $userId) {
            $user = $items->first()->user;
            $rata = $items->avg('score');
            return [
                'nama' => $user ? $user->name : '-',
                'kelas' => $user && $user->class ? $user->class->name : '-',
                'rata_rata' => $rata,
                'ujian' => $items->map(fn($s) => $s->exam ? $s->exam->title : '-')->implode(', '),
            ];
        })->values();
        return response()->json($rekap);
    }
    // Preview PDF (tampil di browser)
    public function previewPdf(Request $request)
    {
        $ujianId = $request->input('ujian_id');
        $kelasId = $request->input('kelas_id');
        $ttd = $request->input('ttd');
        $query = \App\Models\ExamSession::with(['user', 'exam']);
        if ($ujianId) $query->where('exam_id', $ujianId);
        if ($kelasId) $query->whereHas('user', function ($q) use ($kelasId) {
            $q->where('class_id', $kelasId);
        });
        $sessions = $query->get();
        $data = $sessions->map(function ($s) {
            return [
                'nama' => $s->user ? $s->user->name : '-',
                'kelas' => $s->user && $s->user->class ? $s->user->class->name : '-',
                'ujian' => $s->exam ? $s->exam->title : '-',
                'nilai' => $s->score,
                'mulai' => $s->start_time,
                'selesai' => $s->end_time,
                'durasi' => $s->start_time && $s->end_time ? (\Carbon\Carbon::parse($s->start_time)->diffInMinutes($s->end_time) . ' menit') : '-',
            ];
        });
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan_pdf', ['data' => $data, 'ttd' => $ttd]);
        return $pdf->stream('laporan_ujian.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
