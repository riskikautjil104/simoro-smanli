<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClassController as ApiClassController;
use App\Http\Controllers\Api\TeacherController as ApiTeacherController;
use App\Http\Controllers\Api\StudentController as ApiStudentController;
use App\Http\Controllers\Api\SubjectController as ApiSubjectController;
use App\Http\Controllers\Api\ExamController as ApiExamController;
use App\Http\Controllers\Api\QuestionController as ApiQuestionController;
use App\Http\Controllers\Api\MonitoringController as ApiMonitoringController;
use App\Http\Controllers\Api\ReportController as ApiReportController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\URL;

Route::get('/siswa/ujian/{id}/cetak-url', function($id) {
    // Generate signed URL yang expired 15 menit
    $url = URL::temporarySignedRoute(
        'siswa.ujian.hasil.pdf',
        now()->addMinutes(15),
        ['id' => $id]
    );
    return response()->json(['success' => true, 'url' => $url]);
})->middleware('auth:sanctum');

// ==================== PUBLIC ENDPOINTS ====================

// App Config - Public endpoint for mobile app
Route::get('/config', function () {
    return response()->json([
        'success' => true,
        'data' => [
            'app_name' => config('app.app_name', 'Web Skola SMA5'),
            'school_name' => config('app.school_name', 'SMA 5'),
            'tagline' => config('app.tagline', 'Sistem Ujian Online'),
            'location' => config('app.location', ''),
            'theme' => [
                'primary' => config('theme.primary', '#0d6efd'),
                'secondary' => config('theme.secondary', '#6c757d'),
                'background' => config('theme.background', '#ffffff'),
                'surface' => config('theme.surface', '#f8f9fa'),
                'error' => config('theme.error', '#dc3545'),
                'success' => config('theme.success', '#198754'),
                'text_primary' => config('theme.text_primary', '#212529'),
                'text_secondary' => config('theme.text_secondary', '#6c757d'),
            ],
            'features' => [
                'show_onboarding' => config('features.show_onboarding', true),
                'show_notifications' => config('features.show_notifications', true),
                'enable_location_tracking' => config('features.enable_location_tracking', true),
            ],
            'version' => config('app.version', '1.0.0'),
            'maintenance_mode' => (bool) config('app.maintenance_mode', false),
            'maintenance_message' => config('app.maintenance_message', ''),
        ]
    ]);
});

// Login
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});
Route::middleware('auth:sanctum')->group(function () {
    // ==================== ENDPOINTS KHUSUS SISWA (MOBILE API) ====================
    // PENTING: Routes spesifik harus di atas apiResource!

    // Profile
    Route::get('siswa/profile', [ApiStudentController::class, 'profile']);
    Route::put('siswa/profile', [ApiStudentController::class, 'updateProfile']);

    // Ujian - Aktif
    Route::get('siswa/ujian/aktif', [ApiStudentController::class, 'ujianAktif']);

    // Ujian - Riwayat
    Route::get('siswa/ujian/riwayat', [ApiStudentController::class, 'riwayatUjian']);

    // Ujian - Detail & Mulai
    Route::get('siswa/ujian/{id}', [ApiStudentController::class, 'ujianDetail']);
    Route::post('siswa/ujian/{id}/mulai', [ApiStudentController::class, 'mulaiUjian']);

    // Ujian - Submit & Logout
    Route::post('siswa/ujian/{id}/submit', [ApiStudentController::class, 'submitUjian']);
    Route::post('siswa/ujian/{id}/logout', [ApiStudentController::class, 'logoutUjian']);

    // Ujian - Reapply
    Route::post('siswa/ujian/{id}/reapply', [ApiStudentController::class, 'reapplyUjian']);

    // Ujian - Lokasi
    Route::post('siswa/ujian/{id}/lokasi', [ApiStudentController::class, 'simpanLokasiUjian']);

    // Ujian - Detection (mark as detected)
    Route::post('siswa/ujian/{id}/detected', [ApiStudentController::class, 'markDetected']);

    // Ujian - Hasil (id = exam_id)
    Route::get('siswa/ujian/{id}/hasil', [ApiStudentController::class, 'hasilUjian']);
    Route::get('siswa/ujian/{id}/jawaban', [ApiStudentController::class, 'getJawaban']);

    // Ujian - Cetak Hasil (komplit untuk mobile)
    Route::get('siswa/ujian/{id}/cetak', [ApiStudentController::class, 'cetakHasil']);
    Route::get('siswa/ujian/{id}/hasil-pdf', [ApiStudentController::class, 'hasilPdfData']);

    // Dashboard: Kelas, Mata Pelajaran, Jadwal
    Route::get('siswa/dashboard', [ApiStudentController::class, 'dashboard']);

    // API Resources (harus di bawah routes spesifik)
    Route::apiResource('kelas', ApiClassController::class);
    Route::apiResource('guru', ApiTeacherController::class);
    Route::apiResource('siswa', ApiStudentController::class);
    Route::apiResource('mapel', ApiSubjectController::class);
    Route::apiResource('ujian', ApiExamController::class);
    Route::apiResource('soal', ApiQuestionController::class);
    Route::apiResource('monitoring', ApiMonitoringController::class);
    Route::apiResource('laporan', ApiReportController::class);
});
