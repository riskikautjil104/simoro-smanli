<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    // Relasi ke kelas (untuk siswa)
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function previousClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'previous_class_id');
    }

    // Relasi ke mapel (untuk guru)
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'nik',
        'phone',
        'class_id',
        'is_graduated',
        'graduated_at',
        'angkatan',
        'previous_class_id',
        'nis',
        'ttd_signature',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_graduated' => 'boolean',
            'graduated_at' => 'datetime',
        ];
    }

    public function scopeActiveStudents($query)
    {
        return $query->where('role', 'student')->where('is_graduated', false);
    }

    public function scopeGraduatedStudents($query)
    {
        return $query->where('role', 'student')->where('is_graduated', true);
    }
}
