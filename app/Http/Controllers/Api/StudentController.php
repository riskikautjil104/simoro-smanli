<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\StudentAnswer;
use App\Models\Question;
use App\Models\SchoolClass;
use App\Models\Subject;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource (students).
     * GET /api/siswa
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['class:id,name', 'previousClass:id,name']);

        // Filter status kelulusan (Default: hanya siswa aktif kecuali diminta spesifik)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_graduated', false);
            } elseif ($request->status === 'graduated' || $request->status === 'alumni') {
                $query->where('is_graduated', true);
            }
        } elseif ($request->filled('is_graduated')) {
            $query->where('is_graduated', $request->boolean('is_graduated'));
        }

        // Filter kelas
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Pencarian nama, email, nis, phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $query->orderBy('name', 'asc');

        if ($request->boolean('paginate', false)) {
            $perPage = $request->input('per_page', 20);
            $students = $query->paginate($perPage);
        } else {
            $students = $query->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar data siswa berhasil diambil',
            'data'    => $students
        ]);
    }

    /**
     * Store a newly created student.
     * POST /api/siswa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'nis'          => 'required|string|unique:users,nis',
            'nik'          => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'class_id'     => 'nullable|exists:classes,id',
            'angkatan'     => 'nullable|string|max:50',
            'is_graduated' => 'nullable|boolean',
        ], [
            'name.required'     => 'Nama siswa wajib diisi',
            'email.required'    => 'Email siswa wajib diisi',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'nis.required'      => 'NIS siswa wajib diisi',
            'nis.unique'        => 'NIS sudah terdaftar',
        ]);

        $student = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'nis'               => $validated['nis'],
            'nik'               => $validated['nik'] ?? null,
            'phone'             => $validated['phone'] ?? null,
            'class_id'          => $validated['class_id'] ?? null,
            'angkatan'          => $validated['angkatan'] ?? null,
            'is_graduated'      => $request->boolean('is_graduated', false),
            'role'              => 'student',
            'email_verified_at' => now(),
        ]);

        $student->load(['class:id,name']);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil ditambahkan',
            'data'    => $student
        ], 201);
    }

    /**
     * Display the specified student.
     * GET /api/siswa/{id}
     */
    public function show(string $id)
    {
        $student = User::where('role', 'student')
            ->with(['class:id,name', 'previousClass:id,name'])
            ->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        // Ambil riwayat ujian selesai
        $examHistory = ExamSession::where('user_id', $student->id)
            ->whereNotNull('end_time')
            ->with(['exam.subject:id,name,code'])
            ->orderByDesc('end_time')
            ->limit(10)
            ->get()
            ->map(function ($s) {
                return [
                    'session_id'   => $s->id,
                    'exam_id'      => $s->exam_id,
                    'exam_title'   => $s->exam?->title ?? 'Ujian',
                    'subject_name' => $s->exam?->subject?->name ?? '-',
                    'score'        => $s->score,
                    'completed_at' => $s->end_time ? $s->end_time->format('d-m-Y H:i') : '-',
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Detail data siswa berhasil diambil',
            'data'    => [
                'siswa'        => $student,
                'exam_history' => $examHistory,
            ]
        ]);
    }

    /**
     * Update student data.
     * PUT/PATCH /api/siswa/{id}
     */
    public function update(Request $request, string $id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'email'        => 'sometimes|email|unique:users,email,' . $id,
            'password'     => 'nullable|string|min:6',
            'nis'          => 'sometimes|string|unique:users,nis,' . $id,
            'nik'          => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'class_id'     => 'nullable|exists:classes,id',
            'angkatan'     => 'nullable|string|max:50',
            'is_graduated' => 'nullable|boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);
        $student->load(['class:id,name', 'previousClass:id,name']);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui',
            'data'    => $student
        ]);
    }

    /**
     * Remove the specified student.
     * DELETE /api/siswa/{id}
     */
    public function destroy(string $id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil dihapus'
        ]);
    }

    // =========================================================================
    // ====================== ENDPOINTS KHUSUS SISWA ============================
    // =========================================================================

    /**
     * 1. Dashboard Siswa (Data Ringkasan Lengkap untuk Mobile)
     * GET /api/siswa/dashboard
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $kelas = SchoolClass::find($user->class_id);
        $now = now();

        // Ambil daftar ujian aktif kelas siswa saat ini
        $ujiansAktifQuery = Exam::active()
            ->where('class_id', $user->class_id)
            ->where('start_time', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->with(['subject.teacher', 'questions'])
            ->orderBy('start_time', 'asc')
            ->get();

        $ujianAktifList = $ujiansAktifQuery->map(function ($u) use ($user, $now) {
            $session = ExamSession::where('user_id', $user->id)
                ->where('exam_id', $u->id)
                ->first();

            $isCompleted = $session && $session->end_time !== null;
            $isInProgress = $session && $session->is_active && !$isCompleted;

            $durationSec = $u->duration * 60;
            $elapsedSec = $session ? $now->diffInSeconds($session->start_time ?? $now, false) : 0;
            $remainingSec = max($durationSec - abs($elapsedSec), 0);

            $statusText = 'not_started';
            if ($isCompleted) {
                $statusText = 'completed';
            } elseif ($isInProgress) {
                $statusText = 'in_progress';
            } elseif ($session && $session->is_detected) {
                $statusText = 'blocked';
            }

            return [
                'id'                => $u->id,
                'title'             => $u->title,
                'subject_id'        => $u->subject?->id,
                'subject_name'      => $u->subject?->name ?? '-',
                'teacher_name'      => $u->teacher?->name ?? 'Guru Pengampu',
                'duration_minutes'  => $u->duration,
                'total_questions'   => $u->questions->count(),
                'start_time'        => $u->start_time ? $u->start_time->format('d-m-Y H:i') : '-',
                'end_time'          => $u->end_time ? $u->end_time->format('d-m-Y H:i') : '-',
                'session_id'        => $session?->id,
                'session_status'    => $statusText,
                'is_completed'      => $isCompleted,
                'can_start'         => !$isCompleted && ($statusText !== 'blocked'),
                'remaining_seconds' => $isCompleted ? 0 : $remainingSec,
                'score'             => $isCompleted ? $session->score : null,
            ];
        });

        // Ambil riwayat 5 ujian terakhir
        $riwayatTerakhir = ExamSession::where('user_id', $user->id)
            ->whereNotNull('end_time')
            ->with(['exam.subject', 'exam.teacher'])
            ->orderByDesc('end_time')
            ->limit(5)
            ->get()
            ->map(function ($r) {
                $score = $r->score !== null ? (float)$r->score : null;
                $grade = '-';
                if ($score !== null) {
                    if ($score >= 85) $grade = 'A';
                    elseif ($score >= 70) $grade = 'B';
                    elseif ($score >= 55) $grade = 'C';
                    elseif ($score >= 40) $grade = 'D';
                    else $grade = 'E';
                }

                return [
                    'session_id'   => $r->id,
                    'exam_id'      => $r->exam_id,
                    'title'        => $r->exam?->title ?? 'Ujian',
                    'subject_name' => $r->exam?->subject?->name ?? '-',
                    'score'        => $score,
                    'grade'        => $grade,
                    'completed_at' => $r->end_time ? $r->end_time->format('d-m-Y H:i') : '-',
                ];
            });

        // Hitung statistik nilai dan aktivitas
        $totalSelesai = ExamSession::where('user_id', $user->id)->whereNotNull('end_time')->count();
        $avgScore = ExamSession::where('user_id', $user->id)->whereNotNull('score')->avg('score');

        return response()->json([
            'success' => true,
            'message' => 'Dashboard siswa berhasil diambil',
            'data'    => [
                'siswa' => [
                    'id'           => $user->id,
                    'name'         => $user->name,
                    'email'        => $user->email,
                    'nis'          => $user->nis,
                    'phone'        => $user->phone,
                    'class_id'     => $user->class_id,
                    'class_name'   => $kelas?->name ?? '-',
                    'tingkat'      => $kelas?->level,
                    'angkatan'     => $user->angkatan,
                    'is_graduated' => (bool)$user->is_graduated,
                ],
                'stats' => [
                    'ujian_aktif_count'   => $ujianAktifList->where('is_completed', false)->count(),
                    'ujian_selesai_count' => $totalSelesai,
                    'nilai_rata_rata'     => $avgScore !== null ? round((float)$avgScore, 2) : 0,
                ],
                'banners'          => \App\Models\MobileBanner::active()->get(),
                'ujian_aktif'      => $ujianAktifList->values()->all(),
                'riwayat_terakhir' => $riwayatTerakhir->values()->all(),
            ]
        ]);
    }

    /**
     * 2. Daftar Ujian Aktif Siswa
     * GET /api/siswa/ujian/aktif atau GET /api/siswa/ujian
     */
    public function ujianAktif(Request $request)
    {
        $user = $request->user();
        $now = now();

        $ujians = Exam::active()
            ->where('class_id', $user->class_id)
            ->where('start_time', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->with(['subject.teacher', 'questions'])
            ->orderBy('start_time', 'asc')
            ->get();

        $result = $ujians->map(function ($u) use ($user, $now) {
            $session = ExamSession::where('user_id', $user->id)
                ->where('exam_id', $u->id)
                ->first();

            $isCompleted = $session && $session->end_time !== null;
            $isInProgress = $session && $session->is_active && !$isCompleted;

            $durationSec = $u->duration * 60;
            $elapsedSec = $session ? $now->diffInSeconds($session->start_time ?? $now, false) : 0;
            $remainingSec = max($durationSec - abs($elapsedSec), 0);

            $statusText = 'not_started';
            if ($isCompleted) {
                $statusText = 'completed';
            } elseif ($isInProgress) {
                $statusText = 'in_progress';
            } elseif ($session && $session->is_detected) {
                $statusText = 'blocked';
            }

            return [
                'id'                => $u->id,
                'title'             => $u->title,
                'subject_id'        => $u->subject?->id,
                'subject_name'      => $u->subject?->name ?? '-',
                'teacher_name'      => $u->subject?->teacher?->name ?? 'Guru Pengampu',
                'duration_minutes'  => $u->duration,
                'total_questions'   => $u->questions->count(),
                'start_time'        => $u->start_time ? $u->start_time->format('d-m-Y H:i') : '-',
                'end_time'          => $u->end_time ? $u->end_time->format('d-m-Y H:i') : '-',
                'session_id'        => $session?->id,
                'session_status'    => $statusText,
                'is_completed'      => $isCompleted,
                'can_start'         => !$isCompleted && ($statusText !== 'blocked'),
                'remaining_seconds' => $isCompleted ? 0 : $remainingSec,
                'score'             => $isCompleted ? $session->score : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar ujian aktif berhasil diambil',
            'data'    => $result
        ]);
    }

    /**
     * 3. Riwayat Ujian & Daftar Nilai Siswa
     * GET /api/siswa/ujian/riwayat atau GET /api/siswa/nilai
     */
    public function riwayatUjian(Request $request)
    {
        $user = $request->user();

        $riwayat = ExamSession::where('user_id', $user->id)
            ->whereNotNull('end_time')
            ->with(['exam.subject.teacher'])
            ->orderByDesc('end_time')
            ->get();

        $result = $riwayat->map(function ($r) {
            $score = $r->score !== null ? (float)$r->score : null;
            $grade = '-';
            $kkmStatus = '-';

            if ($score !== null) {
                if ($score >= 85) $grade = 'A';
                elseif ($score >= 70) $grade = 'B';
                elseif ($score >= 55) $grade = 'C';
                elseif ($score >= 40) $grade = 'D';
                else $grade = 'E';

                $kkmStatus = $score >= 75 ? 'Tuntas' : 'Remedial';
            }

            return [
                'session_id'   => $r->id,
                'exam_id'      => $r->exam_id,
                'title'        => $r->exam?->title ?? 'Ujian',
                'subject_name' => $r->exam?->subject?->name ?? '-',
                'teacher_name' => $r->exam?->subject?->teacher?->name ?? 'Guru Pengampu',
                'score'        => $score,
                'grade'        => $grade,
                'kkm_status'   => $kkmStatus,
                'status_nilai' => $score !== null ? 'Sudah Dinilai' : 'Menunggu Koreksi Esai',
                'completed_at' => $r->end_time ? $r->end_time->format('d-m-Y H:i') : '-',
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Riwayat nilai ujian berhasil diambil',
            'data'    => $result
        ]);
    }

    /**
     * 4. Detail Ujian Sebelum Mulai
     * GET /api/siswa/ujian/{id}
     */
    public function ujianDetail(Request $request, string $id)
    {
        $user = $request->user();
        $now = now();

        $exam = Exam::with(['subject.teacher', 'questions' => function ($q) {
            $q->select('id', 'exam_id', 'type', 'question_text', 'pertanyaan', 'options', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d');
        }])->find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        $isCompleted = $session && $session->end_time !== null;

        $durationSec = $exam->duration * 60;
        $elapsedSec = $session ? $now->diffInSeconds($session->start_time ?? $now, false) : 0;
        $remainingSec = max($durationSec - abs($elapsedSec), 0);

        // Ambil jawaban yang pernah tersimpan sebelumnya (progress resume)
        $savedAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->pluck('answer', 'question_id');

        // Format butir soal (sembunyikan kunci jawaban)
        $questions = $exam->questions->map(function ($q) use ($savedAnswers) {
            $options = [];
            if (!empty($q->options) && is_array($q->options)) {
                $options = $q->options;
            } else {
                if ($q->opsi_a) $options['a'] = $q->opsi_a;
                if ($q->opsi_b) $options['b'] = $q->opsi_b;
                if ($q->opsi_c) $options['c'] = $q->opsi_c;
                if ($q->opsi_d) $options['d'] = $q->opsi_d;
            }

            return [
                'id'            => $q->id,
                'type'          => $q->type === 'essay' ? 'essay' : 'multiple_choice',
                'question_text' => $q->pertanyaan ?: $q->question_text,
                'options'       => $q->type === 'essay' ? null : $options,
                'saved_answer'  => $savedAnswers[$q->id] ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                => $exam->id,
                'title'             => $exam->title,
                'subject_name'      => $exam->subject?->name ?? '-',
                'teacher_name'      => $exam->subject?->teacher?->name ?? 'Guru Pengampu',
                'duration_minutes'  => $exam->duration,
                'remaining_seconds' => $isCompleted ? 0 : $remainingSec,
                'is_completed'      => $isCompleted,
                'is_session_active' => $session ? (bool)$session->is_active : false,
                'total_questions'   => $questions->count(),
                'answered_count'    => $savedAnswers->count(),
                'questions'         => $questions,
            ]
        ]);
    }

    /**
     * 5. Mulai Sesi Ujian (Start Exam Session)
     * POST /api/siswa/ujian/{id}/mulai
     */
    public function mulaiUjian(Request $request, string $id)
    {
        $user = $request->user();
        $exam = Exam::with(['subject.teacher', 'questions'])->find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        $now = now();

        if ($session && $session->end_time !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian ini sudah pernah diselesaikan dan tidak dapat diulang.'
            ], 403);
        }

        if (!$session) {
            $session = ExamSession::create([
                'user_id'    => $user->id,
                'exam_id'    => $exam->id,
                'start_time' => $now,
                'is_active'  => true,
                'ip_address' => $request->ip(),
                'session_id' => $request->header('User-Agent', 'mobile-simoro'),
            ]);
        } else {
            $session->is_active = true;
            $session->save();
        }

        $durationSec = $exam->duration * 60;
        $elapsedSec = $now->diffInSeconds($session->start_time ?? $now, false);
        $remainingSec = max($durationSec - abs($elapsedSec), 0);

        // Ambil riwayat jawaban yang tersimpan
        $savedAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->pluck('answer', 'question_id');

        $questions = $exam->questions->map(function ($q) use ($savedAnswers) {
            $options = [];
            if (!empty($q->options) && is_array($q->options)) {
                $options = $q->options;
            } else {
                if ($q->opsi_a) $options['a'] = $q->opsi_a;
                if ($q->opsi_b) $options['b'] = $q->opsi_b;
                if ($q->opsi_c) $options['c'] = $q->opsi_c;
                if ($q->opsi_d) $options['d'] = $q->opsi_d;
            }

            return [
                'id'            => $q->id,
                'type'          => $q->type === 'essay' ? 'essay' : 'multiple_choice',
                'question_text' => $q->pertanyaan ?: $q->question_text,
                'options'       => $q->type === 'essay' ? null : $options,
                'saved_answer'  => $savedAnswers[$q->id] ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Sesi ujian berhasil dimulai.',
            'data'    => [
                'session_id'        => $session->id,
                'exam_id'           => $exam->id,
                'title'             => $exam->title,
                'subject_name'      => $exam->subject?->name ?? '-',
                'duration_minutes'  => $exam->duration,
                'remaining_seconds' => $remainingSec,
                'start_time'        => $session->start_time?->toISOString(),
                'total_questions'   => $questions->count(),
                'answered_count'    => $savedAnswers->count(),
                'questions'         => $questions,
            ]
        ]);
    }

    /**
     * 6. Auto-Save Jawaban Per Butir Soal (Sangat penting untuk Mobile App)
     * POST /api/siswa/ujian/{id}/jawab atau POST /api/siswa/ujian/jawab
     */
    public function jawabSoal(Request $request, string $id = null)
    {
        $user = $request->user();

        $validated = $request->validate([
            'exam_id'     => 'sometimes|nullable|integer',
            'question_id' => 'required|integer|exists:questions,id',
            'answer'      => 'required|string',
        ]);

        $examId = $id ?: $request->input('exam_id');
        if (!$examId) {
            $question = Question::find($validated['question_id']);
            $examId = $question?->exam_id;
        }

        if (!$examId) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter exam_id atau ID ujian wajib disertakan.'
            ], 400);
        }

        // Cek sesi ujian
        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $examId)
            ->first();

        if ($session && $session->end_time !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian sudah selesai. Jawaban tidak dapat diubah lagi.'
            ], 403);
        }

        // Simpan atau update jawaban butir soal
        $answer = StudentAnswer::updateOrCreate(
            [
                'user_id'     => $user->id,
                'exam_id'     => $examId,
                'question_id' => $validated['question_id'],
            ],
            [
                'answer' => $validated['answer'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jawaban butir soal berhasil disimpan.',
            'data'    => [
                'question_id' => $answer->question_id,
                'answer'      => $answer->answer,
                'saved_at'    => now()->toISOString(),
            ]
        ]);
    }

    /**
     * 7. Submit & Finalisasi Ujian
     * POST /api/siswa/ujian/{id}/submit
     */
    public function submitUjian(Request $request, string $id)
    {
        $user = $request->user();
        $exam = Exam::with('questions')->find($id);

        if (!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian tidak ditemukan'
            ], 404);
        }

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi ujian tidak ditemukan. Mulai ujian terlebih dahulu.'
            ], 400);
        }

        if ($session->end_time !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Ujian ini sudah pernah diselesaikan sebelumnya.',
                'data'    => [
                    'score'        => $session->score,
                    'completed_at' => $session->end_time?->toISOString(),
                ]
            ], 403);
        }

        // Simpan jawaban batch terakhir jika dikirimkan
        $answers = $request->input('answers', []);
        if (is_array($answers) && !empty($answers)) {
            foreach ($answers as $questionId => $answerValue) {
                StudentAnswer::updateOrCreate(
                    [
                        'user_id'     => $user->id,
                        'exam_id'     => $exam->id,
                        'question_id' => $questionId,
                    ],
                    [
                        'answer' => $answerValue,
                    ]
                );
            }
        }

        // Ambil semua jawaban siswa dari database
        $studentAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->pluck('answer', 'question_id');

        $questions = $exam->questions;
        $totalQuestions = $questions->count();
        $soalPG = $questions->filter(fn($q) => $q->type !== 'essay');
        $soalEssay = $questions->filter(fn($q) => $q->type === 'essay');

        $totalPG = $soalPG->count();
        $benarPG = 0;

        foreach ($soalPG as $q) {
            $jawabanSiswa = $studentAnswers[$q->id] ?? null;
            $kunci = $q->jawaban_benar ?: ($q->answer_key ?: '');

            if (
                $jawabanSiswa !== null &&
                strtolower(trim($jawabanSiswa)) === strtolower(trim($kunci))
            ) {
                $benarPG++;
            }
        }

        // Hitung nilai akhir otomatis
        $score = 0;
        if ($totalQuestions > 0) {
            if ($soalEssay->count() === 0) {
                // Semua PG murni: nilai skala 0 - 100
                $score = $totalPG > 0 ? round(($benarPG / $totalPG) * 100, 2) : 0;
            } else {
                // Ada esai: beri skor proporsional PG terlebih dahulu
                $score = round(($benarPG / $totalQuestions) * 100, 2);
            }
        }

        $session->update([
            'end_time'   => now(),
            'is_active'  => false,
            'ip_address' => $request->ip(),
            'score'      => $score,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil diselesaikan dan seluruh jawaban telah terkumpul.',
            'data'    => [
                'session_id'      => $session->id,
                'score'           => $score,
                'total_questions' => $totalQuestions,
                'total_pg'        => $totalPG,
                'correct_pg'      => $benarPG,
                'total_essay'     => $soalEssay->count(),
                'has_essay'       => $soalEssay->count() > 0,
                'status_koreksi'  => $soalEssay->count() > 0 ? 'Menunggu Penilaian Esai Guru' : 'Sudah Dinilai Otomatis',
                'completed_at'    => now()->toISOString(),
            ]
        ]);
    }

    /**
     * 8. Keluar dari Ujian (Logout Ujian / Pause)
     * POST /api/siswa/ujian/{id}/logout
     */
    public function logoutUjian(Request $request, string $id)
    {
        $user = $request->user();

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->first();

        if ($session) {
            $session->is_active = false;
            $session->logout_time = now();
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil keluar dari sesi ujian. Progres Anda tersimpan.'
        ]);
    }

    /**
     * 9. Rekam Koordinat GPS Lokasi Pengerjaan Ujian
     * POST /api/siswa/ujian/{id}/lokasi
     */
    public function simpanLokasiUjian(Request $request, string $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->first();

        if ($session) {
            $session->lat = $validated['lat'];
            $session->lng = $validated['lng'];
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Titik lokasi GPS berhasil dicatat.'
        ]);
    }

    /**
     * 10. Sensor Deteksi Pelanggaran (Pindah Tab / Keluar Layar)
     * POST /api/siswa/ujian/{id}/detected
     */
    public function markDetected(Request $request, string $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->first();

        if ($session) {
            $session->is_detected = true;
            $session->detection_time = now();
            $session->detection_reason = $validated['reason'];
            $session->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Indikasi pelanggaran tercatat oleh sistem pengawas.'
        ]);
    }

    /**
     * 11. Pengajuan Ulang Akses Ujian (Reapply)
     * POST /api/siswa/ujian/{id}/reapply
     */
    public function reapplyUjian(Request $request, string $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $session = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->firstOrFail();

        $session->reapply_status = 1; // Menunggu persetujuan
        $session->reapply_reason = $validated['alasan'];
        $session->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan pembukaan sesi ujian berhasil dikirimkan ke pengawas.'
        ]);
    }

    /**
     * 12. Ambil Rincian Hasil & Pembahasan Ujian
     * GET /api/siswa/ujian/{id}/hasil
     */
    public function hasilUjian(Request $request, string $id)
    {
        $user = $request->user();

        $examSession = ExamSession::where('exam_id', $id)
            ->where('user_id', $user->id)
            ->with(['exam.subject', 'exam.teacher', 'exam.questions'])
            ->orderByDesc('id')
            ->first();

        if (!$examSession) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi ujian tidak ditemukan'
            ], 404);
        }

        $exam = $examSession->exam;
        $studentAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('exam_id', $id)
            ->get()
            ->keyBy('question_id');

        $questionsData = $exam->questions->map(function ($q) use ($studentAnswers) {
            $ans = $studentAnswers->get($q->id);
            $jawabanSiswa = $ans?->answer;
            $kunci = $q->jawaban_benar ?: ($q->answer_key ?: '');

            $isCorrect = null;
            if ($q->type !== 'essay') {
                $isCorrect = ($jawabanSiswa && $kunci) ? (strtolower(trim($jawabanSiswa)) === strtolower(trim($kunci))) : false;
            }

            return [
                'id'            => $q->id,
                'type'          => $q->type,
                'question_text' => $q->pertanyaan ?: $q->question_text,
                'jawaban_siswa' => $jawabanSiswa,
                'jawaban_benar' => $kunci,
                'is_correct'    => $isCorrect,
                'nilai_essay'   => $ans?->nilai_essay,
            ];
        });

        $score = (float)$examSession->score;
        $grade = 'E';
        if ($score >= 85) $grade = 'A';
        elseif ($score >= 70) $grade = 'B';
        elseif ($score >= 55) $grade = 'C';
        elseif ($score >= 40) $grade = 'D';

        return response()->json([
            'success' => true,
            'message' => 'Hasil ujian berhasil diambil.',
            'data'    => [
                'session_id'   => $examSession->id,
                'exam_id'      => $exam->id,
                'title'        => $exam->title,
                'subject_name' => $exam->subject?->name ?? '-',
                'teacher_name' => $exam->teacher?->name ?? 'Guru Pengampu',
                'score'        => $score,
                'grade'        => $grade,
                'kkm_status'   => $score >= 75 ? 'Tuntas' : 'Remedial',
                'completed_at' => $examSession->end_time ? $examSession->end_time->format('d-m-Y H:i') : '-',
                'questions'    => $questionsData,
            ]
        ]);
    }
}
