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
        Schema::create('rapor_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapor_student_id')->constrained('rapor_students')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            
            // Komponen Nilai
            $table->decimal('nilai_tugas', 5, 2)->default(0);
            $table->decimal('nilai_cbt', 5, 2)->default(0); // Nilai otomatis ditarik dari CBT
            $table->decimal('nilai_akhir', 5, 2)->default(0); // Bobot terhitung
            
            // Capaian Kompetensi / Deskripsi Belajar
            $table->text('capaian_kompetensi')->nullable();
            
            $table->timestamps();
            
            // Unik per rapor dan mapel
            $table->unique(['rapor_student_id', 'subject_id'], 'rapor_subject_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor_scores');
    }
};
