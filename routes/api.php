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

    // Ujian - Hasil
    Route::get('siswa/ujian/{id}/hasil', [ApiStudentController::class, 'hasilUjian']);
    Route::get('siswa/ujian/{id}/jawaban', [ApiStudentController::class, 'getJawaban']);

    // Ujian - Cetak Hasil (komplit untuk mobile)
    Route::get('siswa/ujian/{id}/cetak', [ApiStudentController::class, 'cetakHasil']);

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
