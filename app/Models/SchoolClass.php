<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = ['name', 'wali_kelas_id'];

    // Relasi ke Wali Kelas (Guru)
    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'class_id');
    }

    // Relasi kelas ke mapel (many-to-many)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id');
    }

    // Relasi ke Rapor Siswa
    public function raporStudents(): HasMany
    {
        return $this->hasMany(RaporStudent::class, 'class_id');
    }
}
