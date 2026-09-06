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
        'weight_tugas',
        'weight_cbt',
        'kkm',
        'verification_token',
        'document_serial',
        'digital_signature_hash',
    ];

    protected $casts = [
        'sakit' => 'integer',
        'izin' => 'integer',
        'tanpa_keterangan' => 'integer',
        'tanggal_rapor' => 'date',
        'weight_tugas' => 'float',
        'weight_cbt' => 'float',
        'kkm' => 'float',
    ];

    protected static function booted()
    {
        static::creating(function ($rapor) {
            if (empty($rapor->verification_token)) {
                $rapor->verification_token = \App\Services\RaporSecurityService::generateVerificationToken($rapor);
            }
            if (empty($rapor->document_serial)) {
                $rapor->document_serial = \App\Services\RaporSecurityService::generateDocumentSerial($rapor);
            }
        });
    }

    public function getEffectiveTokenAttribute(): string
    {
        return $this->attributes['verification_token'] ?? \App\Services\RaporSecurityService::generateVerificationToken($this);
    }

    public function getEffectiveSerialAttribute(): string
    {
        return $this->attributes['document_serial'] ?? \App\Services\RaporSecurityService::generateDocumentSerial($this);
    }

    public function getEffectiveHashAttribute(): string
    {
        return $this->attributes['digital_signature_hash'] ?? \App\Services\RaporSecurityService::calculateDigitalSignature($this);
    }

    public function getVerificationUrlAttribute(): string
    {
        return url('/verifikasi-rapor/' . $this->effective_token);
    }

    public function getEncryptedIdAttribute(): string
    {
        return \App\Services\RaporSecurityService::encryptId($this->id);
    }

    public function getEffectiveWeightTugasAttribute(): float
    {
        return (float) ($this->attributes['weight_tugas'] ?? \App\Models\MobileConfig::get('rapor_weight_tugas', 40));
    }

    public function getEffectiveWeightCbtAttribute(): float
    {
        return (float) ($this->attributes['weight_cbt'] ?? \App\Models\MobileConfig::get('rapor_weight_cbt', 60));
    }

    public function getEffectiveKkmAttribute(): float
    {
        return (float) ($this->attributes['kkm'] ?? \App\Models\MobileConfig::get('rapor_kkm_default', 75));
    }

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
