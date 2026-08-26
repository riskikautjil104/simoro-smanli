<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MobileBanner;

class MobileBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Tryout CBT Berbasis Digital SMANLI',
                'subtitle' => 'Tingkatkan kesiapan menghadapi ujian akhir dengan simulasi realtime.',
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=1000&auto=format&fit=crop&q=80',
                'badge_text' => 'HOT',
                'badge_color' => '#ef4444',
                'action_type' => 'url',
                'action_value' => 'https://sma5morotai.sch.id',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Gerakan Siswa Anti-Curang & Jujur',
                'subtitle' => 'Integritas adalah kunci sukses masa depan generasi emas Morotai.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1000&auto=format&fit=crop&q=80',
                'badge_text' => 'PENTING',
                'badge_color' => '#3b82f6',
                'action_type' => 'none',
                'action_value' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Jadwal Penilaian Akhir Semester (PAS)',
                'subtitle' => 'Cek jadwal dan pastikan baterai gadget terisi penuh saat ujian.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1000&auto=format&fit=crop&q=80',
                'badge_text' => 'INFO',
                'badge_color' => '#10b981',
                'action_type' => 'none',
                'action_value' => null,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $b) {
            MobileBanner::updateOrCreate(['title' => $b['title']], $b);
        }
    }
}
