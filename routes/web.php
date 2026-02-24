

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Detail ujian: peserta, ranking, jawaban, simpan nilai, detail page
    Route::get('ujian/{id}/detail', [ExamController::class, 'detail'])->name('ujian.detail');
    Route::get('ujian/{id}/peserta', [ExamController::class, 'peserta']);
    Route::get('ujian/{id}/ranking', [ExamController::class, 'ranking']);
    Route::get('ujian/{ujianId}/peserta/{userId}/jawaban', [ExamController::class, 'jawaban']);
    Route::post('ujian/{ujianId}/peserta/{userId}/nilai', [ExamController::class, 'simpanNilai']);
    Route::get('kelas/list', [ClassController::class, 'list']);
    Route::get('ujian/list', [ExamController::class, 'list']);
    Route::resource('ujian', ExamController::class);
    Route::resource('kelas', ClassController::class);
    Route::resource('guru', TeacherController::class);
    Route::resource('siswa', StudentController::class);
    Route::resource('mapel', SubjectController::class);
    Route::resource('soal', QuestionController::class);
    Route::post('soal/batch', [QuestionController::class, 'batch']);
    Route::get('monitoring/data', [MonitoringController::class, 'data']);
    Route::resource('monitoring', MonitoringController::class);
    Route::resource('laporan', ReportController::class);
});
// Route::get('/admin/ujian/list', [App\Http\Controllers\Admin\ExamController::class, 'list']);
Route::get('/admin/ujian-list', [App\Http\Controllers\Admin\ExamController::class, 'list'])->middleware(['auth', 'verified', 'role:admin']);


// Route siswa CRUD (API/AJAX)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/siswa', [App\Http\Controllers\Admin\StudentController::class, 'index']);
    Route::post('/siswa', [App\Http\Controllers\Admin\StudentController::class, 'store']);
    Route::get('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'show']);
    Route::put('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update']);
    Route::delete('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'destroy']);
});

Route::get('/ujian', [App\Http\Controllers\Admin\ExamController::class, 'list']);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
