<?php

namespace Database\Seeders;

use App\Models\Stack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stacks_defaults = [
            'PHP',
            'Python',
            'Java',
            'Ruby',
            'Elixir',
            'C#',
            'C++',
            'Basic',
            'Delphi',
            'Pascal',
            'JavaScript',
            'TypeScript',
            'Electron',
            'HTML',
            'CSS',
            'MySQL',
            'MariaDB',
            'PostgreSQL',
            'Nginx',
            'Apache',
            'Windows',
            'Linux',
            'Debian',
            'MacOS',
        ];

        // foreach ($stacks_defaults as $stack_title) {
        //     $row = DB::table('stacks')
        //         ->select('title')
        //         ->where(DB::raw('lower(title)'), 'like', '%' . strtolower($stack_title) . '%')
        //         ->first();
        //     if (!$row) {
        //         Stack::create([
        //             'title' => $stack_title,
        //         ]);
        //     }
        // }
    }
}
