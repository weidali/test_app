<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            1 => 'Beginner',
            2 => 'Trainee',
            3 => 'Junior',
            4 => 'Mid-level',
            5 => 'Senior',
            6 => 'Leader',
            7 => 'Architector',
            8 => 'Unicorn',
        ];

        foreach ($levels as $key => $level_title) {
            $level = Level::firstOrCreate([
                'title' => $level_title,
            ], ['position' => $key]);
        }
    }
}
