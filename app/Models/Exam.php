<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject_id',
        'class_id',
        'start_time',
        'end_time',
        'duration',
        'status',
        'is_archived',
        'archived_at'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->hasOneThrough(User::class, Subject::class, 'id', 'id', 'subject_id', 'teacher_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function sessions()
    {
        return $this->hasMany(ExamSession::class, 'exam_id');
    }

    public function examSessions()
    {
        return $this->hasMany(ExamSession::class, 'exam_id');
    }
}
