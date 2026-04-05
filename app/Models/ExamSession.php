<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSession extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'is_detected' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'logout_time' => 'datetime',
        'detection_time' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'exam_id',
        'ip_address',
        'session_id',
        'is_active',
        'start_time',
        'end_time',
        'lat',
        'lng',
        'status_logout',
        'logout_time',
        'reapply_status',
        'reapply_reason',
        'is_detected',
        'detection_time', 
        'detection_reason',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
