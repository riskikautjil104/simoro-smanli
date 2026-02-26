<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        \DB::table('users')->updateOrInsert(
            ['email' => 'admin@sma5.sch.id'],
            [
                'name' => 'Admin SMA5',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // Guru
        \DB::table('users')->updateOrInsert(
            ['email' => 'guru@sma5.sch.id'],
            [
                'name' => 'Budi Guru',
                'password' => bcrypt('guru123'),
                'role' => 'teacher',
                'nip' => '198001011234',
                'phone' => '081234567890',
                // Simulasi ttd_signature base64 (contoh PNG kosong)
                'ttd_signature' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAAFUlEQVR4nO3BMQEAAAgDoJvc6FEOhAAAAABJRU5ErkJggg==',
            ]
        );

        // Siswa
        $classId = \DB::table('classes')->where('name', 'X IPA 1')->value('id');
        if ($classId) {
            \DB::table('users')->updateOrInsert(
                ['email' => 'siswa@sma5.sch.id'],
                [
                    'name' => 'Siti Siswa',
                    'password' => bcrypt('siswa123'),
                    'role' => 'student',
                    'nis' => '22001',
                    'class_id' => $classId,
                ]
            );
        } else {
            info('Seeder UserSeeder: Kelas X IPA 1 tidak ditemukan, siswa tidak diinsert!');
        }
    }
}
