<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduation extends Model
{
    protected $fillable = [
        'user_id',
        'nisn',
        'name',
        'status',
        'angkatan',
        'class_name',
        'tahun_ajaran',
        'is_archived',
        'archived_at'
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }
}
