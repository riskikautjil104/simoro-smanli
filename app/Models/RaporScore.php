<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaporScore extends Model
{
    use HasFactory;

    protected $table = 'rapor_scores';

    protected $fillable = [
        'rapor_student_id',
        'subject_id',
        'nilai_tugas',
        'nilai_cbt',
        'nilai_akhir',
        'capaian_kompetensi',
    ];

    protected $casts = [
        'nilai_tugas' => 'float',
        'nilai_cbt' => 'float',
        'nilai_akhir' => 'float',
    ];

    public function raporStudent(): BelongsTo
    {
        return $this->belongsTo(RaporStudent::class, 'rapor_student_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Hitung otomatis nilai akhir berdasarkan bobot: Tugas % + CBT %
     */
    public function calculateFinalScore(float $weightTugas = 0.40, float $weightCbt = 0.60): float
    {
        $wTugas = $weightTugas > 1.0 ? ($weightTugas / 100) : $weightTugas;
        $wCbt   = $weightCbt > 1.0 ? ($weightCbt / 100) : $weightCbt;

        $final = ($this->nilai_tugas * $wTugas) + ($this->nilai_cbt * $wCbt);
        $this->nilai_akhir = round($final, 2);
        return $this->nilai_akhir;
    }
}
