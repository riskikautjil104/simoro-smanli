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
        // Statistik dashboard
        Route::get('dashboard/stats', [\App\Http\Controllers\Admin\DashboardController::class, 'stats']);
        Route::get('dashboard/chart', [\App\Http\Controllers\Admin\DashboardController::class, 'chart']);
        // Halaman dan API TTD admin
        Route::get('ttd', [\App\Http\Controllers\Admin\AdminProfileController::class, 'editTtd'])->name('ttd.edit');
        Route::post('ttd', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updateTtd'])->name('ttd.update');
        Route::get('ttd/json', function () {
            return response()->json(['ttd_signature' => auth()->user()->ttd_signature]);
        })->name('ttd.json');
        Route::get('ttd/json', function () {
            $user = auth()->user();
            return response()->json(['ttd_signature' => $user->ttd_signature]);
        });
        Route::get('ttd', [\App\Http\Controllers\Admin\AdminProfileController::class, 'editTtd'])->name('ttd.edit');
        Route::post('ttd', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updateTtd'])->name('ttd.update');
        Route::get('laporan/rekap-siswa', [ReportController::class, 'rekapSiswa']);
        Route::get('laporan/preview-pdf', [ReportController::class, 'previewPdf']);
        Route::get('laporan/export-excel', [ReportController::class, 'exportExcel']);
        Route::get('laporan/export-pdf', [ReportController::class, 'exportPdf']);
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
        Route::get('laporan/data', [ReportController::class, 'data']);
        Route::resource('laporan', ReportController::class);
    });
    // Route::get('/admin/ujian/list', [App\Http\Controllers\Admin\ExamController::class, 'list']);
    Route::get('/admin/ujian-list', [App\Http\Controllers\Admin\ExamController::class, 'list'])->middleware(['auth', 'verified', 'role:admin']);

    // Route group untuk guru
    Route::middleware(['auth', 'verified', 'role:teacher'])->prefix('guru')->name('guru.')->group(function () {
        Route::view('periksa', 'guru.periksa')->name('periksa');
        // Penilaian/priksa jawaban siswa per ujian (fitur guru)
        Route::get('ujian/{id}/peserta', [\App\Http\Controllers\Guru\UjianController::class, 'peserta'])->name('ujian.peserta');
        Route::get('ujian/{ujianId}/peserta/{userId}/jawaban', [\App\Http\Controllers\Guru\UjianController::class, 'jawaban'])->name('ujian.jawaban');
        Route::post('ujian/{ujianId}/peserta/{userId}/nilai', [\App\Http\Controllers\Guru\UjianController::class, 'simpanNilai'])->name('ujian.simpanNilai');
        // TTD Guru
        Route::get('ttd', [\App\Http\Controllers\Guru\TtdController::class, 'edit'])->name('ttd.edit');
        Route::post('ttd', [\App\Http\Controllers\Guru\TtdController::class, 'update'])->name('ttd.update');
        Route::get('hasil/filters', [\App\Http\Controllers\Guru\HasilFilterController::class, 'filters'])->name('hasil.filters');
        Route::view('soal/batch', 'guru.soal-batch-create')->name('soal.batch');
        Route::post('soal/batch', [\App\Http\Controllers\Guru\SoalBatchController::class, 'store'])->name('soal.batch.store');
        Route::get('dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');
        Route::get('dashboard/stats', [\App\Http\Controllers\Guru\DashboardController::class, 'stats']);
        // Menu lain: mapel, soal, ujian, monitoring, hasil
        // Route::get('mapel', ...)->name('mapel');
        // Route::get('soal', ...)->name('soal');
        // Route::get('ujian', ...)->name('ujian');
        // Route::get('monitoring', ...)->name('monitoring');
        // Route::get('hasil', ...)->name('hasil');
        Route::view('mapel', 'guru.mapel')->name('mapel');
        Route::get('mapel/list', [\App\Http\Controllers\Guru\MapelController::class, 'index'])->name('mapel.list');
        Route::view('soal', 'guru.soal')->name('soal');
        Route::view('soal/create', 'guru.soal-create')->name('soal.create');
        Route::get('soal/list', [\App\Http\Controllers\Guru\SoalController::class, 'index'])->name('soal.list');
        Route::post('soal/store', [\App\Http\Controllers\Guru\SoalStoreController::class, 'store'])->name('soal.store');
        Route::get('soal/filters', [\App\Http\Controllers\Guru\SoalFilterController::class, 'filters'])->name('soal.filters');
        Route::view('ujian', 'guru.ujian')->name('ujian');
        Route::view('ujian/create', 'guru.ujian-create')->name('ujian.create');
        Route::get('ujian/list', [\App\Http\Controllers\Guru\UjianController::class, 'index'])->name('ujian.list');
        Route::post('ujian/store', [\App\Http\Controllers\Guru\UjianStoreController::class, 'store'])->name('ujian.store');
        Route::view('monitoring', 'guru.monitoring')->name('monitoring');
        Route::view('hasil', 'guru.hasil')->name('hasil');
        Route::get('hasil/list', [\App\Http\Controllers\Guru\HasilController::class, 'index'])->name('hasil.list');
        Route::post('ujian/{ujianId}/peserta/{userId}/nilai-per-soal', [\App\Http\Controllers\Guru\UjianController::class, 'simpanNilaiPerSoal'])->name('ujian.simpanNilaiPerSoal');
    });
    // Route dashboard siswa
    Route::middleware(['auth', 'verified', 'role:student'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
        Route::get('ujian/aktif', [\App\Http\Controllers\Siswa\DashboardController::class, 'ujianAktif']);
        Route::get('ujian/riwayat', [\App\Http\Controllers\Siswa\DashboardController::class, 'riwayatUjian']);
        Route::get('ujian/{id}', [\App\Http\Controllers\Siswa\DashboardController::class, 'ujianDetail'])->name('ujian.detail');
        Route::post('ujian/{id}/submit', [\App\Http\Controllers\Siswa\DashboardController::class, 'submitUjian'])->name('ujian.submit');
    });
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
    })->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
