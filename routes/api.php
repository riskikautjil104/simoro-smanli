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
    Route::apiResource('kelas', ApiClassController::class);
    Route::apiResource('guru', ApiTeacherController::class);
    Route::apiResource('siswa', ApiStudentController::class);
    Route::apiResource('mapel', ApiSubjectController::class);
    Route::apiResource('ujian', ApiExamController::class);
    Route::apiResource('soal', ApiQuestionController::class);
    Route::apiResource('monitoring', ApiMonitoringController::class);
    Route::apiResource('laporan', ApiReportController::class);
});
