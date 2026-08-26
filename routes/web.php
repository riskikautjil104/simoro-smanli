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

    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // CKEditor image upload
        Route::post('upload-image', [\App\Http\Controllers\Admin\CkeditorUploadController::class, 'upload'])->name('ckeditor.upload');
        Route::post('ujian/{ujianId}/peserta/{userId}/reapply/approve', [\App\Http\Controllers\Admin\ExamController::class, 'approveReapply'])->name('ujian.reapply.approve');
        Route::post('ujian/{ujianId}/peserta/{userId}/reapply/reject', [\App\Http\Controllers\Admin\ExamController::class, 'rejectReapply'])->name('ujian.reapply.reject');
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
        Route::get('ujian/arsip', [ExamController::class, 'arsipView'])->name('ujian.arsip');
        Route::get('ujian/arsip/list', [ExamController::class, 'arsipList'])->name('ujian.arsip.list');
        Route::post('ujian/{id}/archive', [ExamController::class, 'archive'])->name('ujian.archive');
        Route::post('ujian/{id}/unarchive', [ExamController::class, 'unarchive'])->name('ujian.unarchive');
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
        Route::get('kelulusan/alumni', [\App\Http\Controllers\Admin\GraduationController::class, 'alumniView'])->name('kelulusan.alumni');
        Route::get('kelulusan/arsip', [\App\Http\Controllers\Admin\GraduationController::class, 'alumniView'])->name('kelulusan.arsip');
        Route::post('kelulusan/pull-kelas', [\App\Http\Controllers\Admin\GraduationController::class, 'pullKelas'])->name('kelulusan.pull-kelas');
        Route::post('kelulusan/kelulusan-massal', [\App\Http\Controllers\Admin\GraduationController::class, 'kelulusanMassal'])->name('kelulusan.kelulusan-massal');
        Route::post('kelulusan/{id}/set-status', [\App\Http\Controllers\Admin\GraduationController::class, 'setStatus'])->name('kelulusan.set-status');
        Route::post('kelulusan/archive-all', [\App\Http\Controllers\Admin\GraduationController::class, 'archiveAll'])->name('kelulusan.archive-all');
        Route::post('kelulusan/{id}/archive', [\App\Http\Controllers\Admin\GraduationController::class, 'archive'])->name('kelulusan.archive');
        Route::post('kelulusan/{id}/unarchive', [\App\Http\Controllers\Admin\GraduationController::class, 'unarchive'])->name('kelulusan.unarchive');
        Route::get('kelulusan/alumni/export-excel', [\App\Http\Controllers\Admin\GraduationController::class, 'exportArsipExcel'])->name('kelulusan.alumni.export-excel');
        Route::get('kelulusan/alumni/export-pdf', [\App\Http\Controllers\Admin\GraduationController::class, 'exportArsipPdf'])->name('kelulusan.alumni.export-pdf');
        Route::get('kelulusan/arsip/export-excel', [\App\Http\Controllers\Admin\GraduationController::class, 'exportArsipExcel'])->name('kelulusan.arsip.export-excel');
        Route::get('kelulusan/arsip/export-pdf', [\App\Http\Controllers\Admin\GraduationController::class, 'exportArsipPdf'])->name('kelulusan.arsip.export-pdf');
        Route::get('kelulusan/export-excel', [\App\Http\Controllers\Admin\GraduationController::class, 'exportExcel'])->name('kelulusan.export-excel');
        Route::get('kelulusan/export-pdf', [\App\Http\Controllers\Admin\GraduationController::class, 'exportPdf'])->name('kelulusan.export-pdf');
        Route::resource('kelulusan', \App\Http\Controllers\Admin\GraduationController::class);
    });
    // Route::get('/admin/ujian/list', [App\Http\Controllers\Admin\ExamController::class, 'list']);
    Route::get('/admin/ujian-list', [App\Http\Controllers\Admin\ExamController::class, 'list'])->middleware(['auth', 'role:admin']);
    Route::get('/admin/ujian-arsip-list', [App\Http\Controllers\Admin\ExamController::class, 'arsipList'])->middleware(['auth', 'role:admin']);

    // Route group untuk guru
    Route::middleware(['auth', 'role:teacher'])->prefix('guru')->name('guru.')->group(function () {
        Route::view('periksa', 'guru.periksa')->name('periksa');
        // Penilaian/priksa jawaban siswa per ujian (fitur guru)
        Route::get('ujian/{id}/peserta', [\App\Http\Controllers\Guru\UjianController::class, 'peserta'])->name('ujian.peserta');
        Route::get('ujian/{ujianId}/peserta/{userId}/jawaban', [\App\Http\Controllers\Guru\UjianController::class, 'jawaban'])->name('ujian.jawaban');
        Route::post('ujian/{ujianId}/peserta/{userId}/nilai', [\App\Http\Controllers\Guru\UjianController::class, 'simpanNilai'])->name('ujian.simpanNilai');
        // TTD Guru
        Route::get('ttd', [\App\Http\Controllers\Guru\TtdController::class, 'edit'])->name('ttd.edit');
        Route::post('ttd', [\App\Http\Controllers\Guru\TtdController::class, 'update'])->name('ttd.update');
        Route::get('hasil/filters', [\App\Http\Controllers\Guru\HasilFilterController::class, 'filters'])->name('hasil.filters');
        Route::post('upload-image', [\App\Http\Controllers\Admin\CkeditorUploadController::class, 'upload'])->name('upload.image');
        Route::view('soal/batch', 'guru.soal-batch-create')->name('soal.batch');
        Route::post('soal/batch', [\App\Http\Controllers\Guru\SoalBatchController::class, 'store'])->name('soal.batch.store');
        Route::get('dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');
        Route::get('dashboard/stats', [\App\Http\Controllers\Guru\DashboardController::class, 'stats']);
        Route::view('mapel', 'guru.mapel')->name('mapel');
        Route::get('mapel/list', [\App\Http\Controllers\Guru\MapelController::class, 'index'])->name('mapel.list');
        
        Route::view('soal/create', 'guru.soal-create')->name('soal.create');
        Route::get('soal/list', [\App\Http\Controllers\Guru\SoalController::class, 'index'])->name('soal.list');
        Route::post('soal/store', [\App\Http\Controllers\Guru\SoalStoreController::class, 'store'])->name('soal.store');
        Route::get('soal/filters', [\App\Http\Controllers\Guru\SoalFilterController::class, 'filters'])->name('soal.filters');
        Route::view('ujian', 'guru.ujian')->name('ujian');
        Route::view('ujian/create', 'guru.ujian-create')->name('ujian.create');
        Route::get('ujian/list', [\App\Http\Controllers\Guru\UjianController::class, 'index'])->name('ujian.list');
        Route::get('ujian/{id}/detail', [\App\Http\Controllers\Guru\UjianController::class, 'detail'])->name('ujian.detail');
        Route::post('ujian/store', [\App\Http\Controllers\Guru\UjianStoreController::class, 'store'])->name('ujian.store');
        Route::view('monitoring', 'guru.monitoring')->name('monitoring');
        Route::get('monitoring/data', [\App\Http\Controllers\Guru\MonitoringController::class, 'data'])->name('monitoring.data');
        Route::view('hasil', 'guru.hasil')->name('hasil');
        Route::get('hasil/list', [\App\Http\Controllers\Guru\HasilController::class, 'index'])->name('hasil.list');
        Route::post('ujian/{ujianId}/peserta/{userId}/nilai-per-soal', [\App\Http\Controllers\Guru\UjianController::class, 'simpanNilaiPerSoal'])->name('ujian.simpanNilaiPerSoal');
        Route::get('soal/{id}',    [\App\Http\Controllers\Guru\SoalController::class, 'show'])   ->name('soal.show');
        Route::post('soal/{id}',   [\App\Http\Controllers\Guru\SoalController::class, 'update']) ->name('soal.update');
        Route::delete('soal/{id}', [\App\Http\Controllers\Guru\SoalController::class, 'destroy'])->name('soal.destroy');
        Route::view('soal', 'guru.soal')->name('soal');

        // Berita Acara Ujian Guru
        Route::get('berita-acara', [\App\Http\Controllers\Guru\BeritaAcaraController::class, 'index'])->name('berita-acara.index');
        Route::get('berita-acara/{examId}', [\App\Http\Controllers\Guru\BeritaAcaraController::class, 'show'])->name('berita-acara.show');
        Route::get('berita-acara/{examId}/pdf', [\App\Http\Controllers\Guru\BeritaAcaraController::class, 'exportPdf'])->name('berita-acara.pdf');
        Route::get('berita-acara/{examId}/excel', [\App\Http\Controllers\Guru\BeritaAcaraController::class, 'exportExcel'])->name('berita-acara.excel');
    });

    Route::middleware(['auth', 'role:student'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');

        // ✅ Semua route SPESIFIK harus di atas {id}
        Route::view('ujian/aktif', 'siswa.ujian-aktif')->name('ujian.aktif');
        Route::get('ujian/aktif/json', [\App\Http\Controllers\Siswa\DashboardController::class, 'ujianAktif']);

        Route::view('ujian/riwayat', 'siswa.ujian-riwayat')->name('ujian.riwayat');
        Route::get('ujian/riwayat/json', [\App\Http\Controllers\Siswa\DashboardController::class, 'riwayatUjian']);

        // ✅ Route logout & lokasi juga harus di atas {id}
        Route::post('ujian/logout', [\App\Http\Controllers\Siswa\DashboardController::class, 'logoutUjian']);
        Route::post('ujian/lokasi', [\App\Http\Controllers\Siswa\DashboardController::class, 'simpanLokasiUjian']);

        // ⬇️ Route {id} PALING BAWAH
        Route::get('ujian/{id}', [\App\Http\Controllers\Siswa\DashboardController::class, 'ujianDetail'])->name('ujian.detail');
        Route::post('ujian/{id}/reapply', [\App\Http\Controllers\Siswa\DashboardController::class, 'reapplyUjian'])->name('ujian.reapply');
        Route::get('ujian/{id}/hasil', [\App\Http\Controllers\Siswa\DashboardController::class, 'cetakHasilUjian'])->name('ujian.hasil');
        Route::get('ujian/{id}/hasil/pdf', [\App\Http\Controllers\Siswa\HasilUjianPdfController::class, 'hasilPdf'])->name('ujian.hasil.pdf');
        Route::post('ujian/{id}/submit', [\App\Http\Controllers\Siswa\DashboardController::class, 'submitUjian'])->name('ujian.submit');
    });

    // Route mobile manager
    Route::middleware(['auth', 'role:mobile'])->prefix('mobile')->name('mobile.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Mobile\DashboardController::class, 'index'])->name('dashboard');
        Route::get('config', [\App\Http\Controllers\Mobile\DashboardController::class, 'getConfig'])->name('config');
        Route::post('config/app', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateAppConfig'])->name('config.app');
        Route::post('config/assets', [\App\Http\Controllers\Mobile\DashboardController::class, 'uploadAssets'])->name('config.assets');
        Route::post('config/lottie', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateLottie'])->name('config.lottie');
        Route::post('config/theme', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateTheme'])->name('config.theme');
        Route::post('config/features', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateFeatures'])->name('config.features');
        Route::post('config/contact', [\App\Http\Controllers\Mobile\DashboardController::class, 'updateContact'])->name('config.contact');

        // Manajemen Banner Iklan & Promo
        Route::get('banners', [\App\Http\Controllers\Mobile\BannerController::class, 'index'])->name('banners.index');
        Route::post('banners', [\App\Http\Controllers\Mobile\BannerController::class, 'store'])->name('banners.store');
        Route::post('banners/{id}', [\App\Http\Controllers\Mobile\BannerController::class, 'update'])->name('banners.update');
        Route::delete('banners/{id}', [\App\Http\Controllers\Mobile\BannerController::class, 'destroy'])->name('banners.destroy');
        Route::post('banners/{id}/toggle', [\App\Http\Controllers\Mobile\BannerController::class, 'toggleStatus'])->name('banners.toggle');
    });
    // Route siswa CRUD (API/AJAX)
    Route::middleware('auth')->group(function () {
        Route::get('/siswa', [App\Http\Controllers\Admin\StudentController::class, 'index']);
        Route::post('/siswa', [App\Http\Controllers\Admin\StudentController::class, 'store']);
        Route::get('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'show']);
        Route::put('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update']);
        Route::delete('/siswa/{id}', [App\Http\Controllers\Admin\StudentController::class, 'destroy']);
    });

    // Route group untuk Kepala Sekolah
    Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Kepsek\DashboardController::class, 'index'])->name('dashboard');
        Route::get('monitoring', [\App\Http\Controllers\Kepsek\MonitoringController::class, 'index'])->name('monitoring');
        Route::get('monitoring/data', [\App\Http\Controllers\Kepsek\MonitoringController::class, 'data'])->name('monitoring.data');
        Route::get('laporan', [\App\Http\Controllers\Kepsek\LaporanController::class, 'index'])->name('laporan');
        Route::get('laporan/data', [\App\Http\Controllers\Kepsek\LaporanController::class, 'data'])->name('laporan.data');
        Route::get('berita-acara', [\App\Http\Controllers\Kepsek\BeritaAcaraController::class, 'index'])->name('berita-acara');
        Route::get('berita-acara/{examId}', [\App\Http\Controllers\Kepsek\BeritaAcaraController::class, 'show'])->name('berita-acara.show');
        Route::get('berita-acara/{examId}/pdf', [\App\Http\Controllers\Kepsek\BeritaAcaraController::class, 'exportPdf'])->name('berita-acara.pdf');
        Route::get('ttd', [\App\Http\Controllers\Kepsek\TtdController::class, 'edit'])->name('ttd.edit');
        Route::post('ttd', [\App\Http\Controllers\Kepsek\TtdController::class, 'update'])->name('ttd.update');
    });

    Route::get('/ujian', [App\Http\Controllers\Admin\ExamController::class, 'list']);
Route::get('/ranking', [\App\Http\Controllers\Frontend\RankingController::class, 'index'])->name('public.ranking');
Route::get('/ranking/{id}', [\App\Http\Controllers\Frontend\RankingController::class, 'show'])->name('public.ranking.show');

Route::get('/pengumuman', [\App\Http\Controllers\Frontend\PengumumanController::class, 'index'])->name('public.pengumuman');
Route::post('/pengumuman/cek', [\App\Http\Controllers\Frontend\PengumumanController::class, 'cek'])->name('public.pengumuman.cek');

Route::get('/docs', function () {
    return view('frontend.docs');
})->name('public.docs');
Route::get('/dokumentasi', function () {
    return view('frontend.docs');
});
Route::get('/panduan', function () {
    return view('frontend.docs');
});

Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index']);

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'role:admin'])->name('admin.dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
