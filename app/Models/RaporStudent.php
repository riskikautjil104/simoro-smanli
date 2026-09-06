<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RaporStudent extends Model
{
    use HasFactory;

    protected $table = 'rapor_students';

    protected $fillable = [
        'student_id',
        'class_id',
        'wali_kelas_id',
        'tahun_ajaran',
        'semester',
        'sakit',
        'izin',
        'tanpa_keterangan',
        'catatan_wali_kelas',
        'status_kenaikan',
        'status',
        'tanggal_rapor',
    ];

    protected $casts = [
        'sakit' => 'integer',
        'izin' => 'integer',
        'tanpa_keterangan' => 'integer',
        'tanggal_rapor' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(RaporScore::class, 'rapor_student_id');
    }

    /**
     * Hitung rata-rata nilai akhir rapor
     */
    public function getAverageScoreAttribute(): float
    {
        if ($this->scores->isEmpty()) {
            return 0.0;
        }
        return round($this->scores->avg('nilai_akhir'), 2);
    }
}
