<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rapor_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tahun_ajaran', 20)->default('2025/2026'); // Contoh: 2025/2026
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
            
            // Rekap Presensi Semester
            $table->unsignedInteger('sakit')->default(0);
            $table->unsignedInteger('izin')->default(0);
            $table->unsignedInteger('tanpa_keterangan')->default(0);
            
            // Evaluasi & Catatan
            $table->text('catatan_wali_kelas')->nullable();
            $table->string('status_kenaikan')->nullable(); // 'Naik ke kelas XI', 'Lulus', dll
            
            // Status Rapor
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->date('tanggal_rapor')->nullable();
            
            $table->timestamps();
            
            // Unik per siswa, tahun ajaran, dan semester
            $table->unique(['student_id', 'tahun_ajaran', 'semester'], 'student_rapor_semester_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor_students');
    }
};
