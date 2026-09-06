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

// ==================== PUBLIC CONFIG & BANNERS (MOBILE APP) ====================
Route::get('/config', [\App\Http\Controllers\Mobile\DashboardController::class, 'getPublicConfig']);
Route::get('/mobile/public-config', [\App\Http\Controllers\Mobile\DashboardController::class, 'getPublicConfig']);
Route::get('/banners', [\App\Http\Controllers\Mobile\BannerController::class, 'getActiveBanners']);

// ==================== MOBILE SETTINGS API (MOBILE MANAGER / ADMIN) ====================
Route::get('mobile/config', [\App\Http\Controllers\Mobile\DashboardController::class, 'getConfig']);
Route::post('mobile/config', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateAll']);
Route::post('mobile/config/app', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateAppConfig']);
Route::post('mobile/config/assets', [\App\Http\Controllers\Mobile\DashboardController::class, 'uploadAssets']);
Route::post('mobile/config/lottie', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateLottie']);
Route::post('mobile/config/theme', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateTheme']);
Route::post('mobile/config/features', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateFeatures']);
Route::post('mobile/config/contact', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateContact']);

// Mobile Banners Management
Route::get('mobile/banners', [\App\Http\Controllers\Mobile\BannerController::class, 'index']);
Route::post('mobile/banners', [\App\Http\Controllers\Mobile\BannerController::class, 'store']);
Route::post('mobile/banners/{id}', [\App\Http\Controllers\Mobile\BannerController::class, 'update']);
Route::delete('mobile/banners/{id}', [\App\Http\Controllers\Mobile\BannerController::class, 'destroy']);
Route::post('mobile/banners/{id}/toggle', [\App\Http\Controllers\Mobile\BannerController::class, 'toggleStatus']);

// ==================== AUTH & PROFILE SISWA ====================
// Login Siswa dengan proteksi rate limit brute force (10 request/menit per IP)
Route::post('siswa/login', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'login'])
    ->middleware('throttle:api-login');

// Login Umum (Legacy / Multi-Role)
Route::post('login', [AuthController::class, 'login'])
    ->middleware('throttle:api-login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // ==================== ENDPOINTS KHUSUS SISWA (MOBILE API) ====================
    // Auth & Profile Siswa
    Route::post('siswa/logout', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'logout']);
    Route::get('siswa/profile', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'profile']);
    Route::get('siswa/me', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'profile']);
    Route::put('siswa/profile', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'updateProfile']);
    Route::post('siswa/profile', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'updateProfile']);
    Route::post('siswa/agama', [ApiStudentController::class, 'updateAgama']);
    Route::post('siswa/change-password', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'changePassword']);
    Route::put('siswa/password', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'changePassword']);
    // awal batas suci yang kamu ubah
    // FCM Device Token — dipanggil Flutter saat login berhasil
    Route::post('siswa/device-token', [\App\Http\Controllers\Api\Siswa\AuthController::class, 'updateDeviceToken']);
    // akhir batas suci yang kamu ubah

    // Dashboard Siswa
    Route::get('siswa/dashboard', [ApiStudentController::class, 'dashboard']);

    // Ujian - Aktif
    Route::get('siswa/ujian/aktif', [ApiStudentController::class, 'ujianAktif']);
    Route::get('siswa/ujian', [ApiStudentController::class, 'ujianAktif']);

    // Ujian - Riwayat & Nilai
    Route::get('siswa/ujian/riwayat', [ApiStudentController::class, 'riwayatUjian']);
    Route::get('siswa/nilai', [ApiStudentController::class, 'riwayatUjian']);

    // Ujian - Detail & Mulai
    Route::get('siswa/ujian/{id}', [ApiStudentController::class, 'ujianDetail']);
    Route::post('siswa/ujian/{id}/mulai', [ApiStudentController::class, 'mulaiUjian']);

    // Ujian - Jawab Butir Soal (Auto-save)
    Route::post('siswa/ujian/{id}/jawab', [ApiStudentController::class, 'jawabSoal']);
    Route::post('siswa/ujian/jawab', [ApiStudentController::class, 'jawabSoal']);

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

    // ==================== E-RAPOR DIGITAL SISWA (MOBILE API) ====================
    Route::get('siswa/rapor', [\App\Http\Controllers\Api\Siswa\RaporApiController::class, 'index']);
    Route::get('siswa/rapor/{id}', [\App\Http\Controllers\Api\Siswa\RaporApiController::class, 'show']);
    Route::get('siswa/rapor/{id}/pdf', [\App\Http\Controllers\Api\Siswa\RaporApiController::class, 'downloadPdf']);

    // User Accounts Management (Seluruh Akun & Role)
    Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);
    Route::apiResource('akun', \App\Http\Controllers\Api\UserController::class);
    Route::post('users/{id}/reset-password', [\App\Http\Controllers\Api\UserController::class, 'resetPassword']);
    Route::post('akun/{id}/reset-password', [\App\Http\Controllers\Api\UserController::class, 'resetPassword']);
    Route::post('guru/{id}/reset-password', [ApiTeacherController::class, 'resetPassword']);

    // API Resources Akademik & Master Data (harus di bawah routes spesifik)
    Route::apiResource('kelas', ApiClassController::class);
    Route::apiResource('classes', ApiClassController::class);
    Route::apiResource('guru', ApiTeacherController::class);
    Route::apiResource('teachers', ApiTeacherController::class);
    Route::apiResource('siswa', ApiStudentController::class);
    Route::apiResource('students', ApiStudentController::class);
    Route::apiResource('alumni', \App\Http\Controllers\Api\AlumniController::class);
    Route::apiResource('mapel', ApiSubjectController::class);
    Route::apiResource('subjects', ApiSubjectController::class);
    Route::apiResource('ujian', ApiExamController::class);
    Route::apiResource('soal', ApiQuestionController::class);
    Route::apiResource('monitoring', ApiMonitoringController::class);
    Route::apiResource('laporan', ApiReportController::class);
});

// Public Read-only Endpoints untuk Data Akademik & Akun Terbuka
Route::get('public/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
Route::get('public/akun', [\App\Http\Controllers\Api\UserController::class, 'index']);
Route::get('public/kelas', [ApiClassController::class, 'index']);
Route::get('public/guru', [ApiTeacherController::class, 'index']);
Route::get('public/mapel', [ApiSubjectController::class, 'index']);
Route::get('public/alumni', [\App\Http\Controllers\Api\AlumniController::class, 'index']);

// batas suci


