<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileBanner extends Model
{
    use HasFactory;

    protected $table = 'mobile_banners';

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'badge_text',
        'badge_color',
        'action_type',
        'action_value',
        'order',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = [
        'image_url',
    ];

    /**
     * URL absolut publik untuk gambar banner
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('assets/img/banner-placeholder.png');
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    /**
     * Scope untuk mengambil banner aktif dan sesuai jadwal tayang
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $now);
            })
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc');
    }
}
