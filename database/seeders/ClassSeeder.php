<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'X IPA 1'],
            ['name' => 'X IPA 2'],
            ['name' => 'XI IPS 1'],
            ['name' => 'XII IPA 1'],
        ];
        \DB::table('classes')->insert($classes);
    }
}
