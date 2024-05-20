<?php

namespace Database\Seeders;

use App\Models\CategoryOfStack;
use App\Models\Stack;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryOfStackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Operating System (OS)' => [
                'Windows',
                'Linux',
                'Debian',
                'MacOS',
            ],
            'Server-side Programming' => [
                'PHP',
                'Python',
                'Java',
                'Ruby',
                'C#',
                'C++',
                'Basic',
                'Delphi',
                'Pascal',
                'Elixir',
            ],
            'Client-side Programming' => [
                'JavaScript',
                'TypeScript',
                'Electron',
                'HTML',
                'CSS',
            ],
            'Frontend Frameworks/Libraries' => [
                'ReactJS',
                'VueJS',
                'Angular',
                'Ember',
            ],
            'Database' => [
                'MySQL',
                'MariaDB',
                'PostgreSQL',
                'MongoDB',
            ],
            'WebServer' => [
                'Nginx',
                'Apache',
            ],
            'Deployment $ Infrastructure' => [
                'Docker',
                'Kubernetes',
            ],
        ];
        foreach ($categories as $key => $value) {
            $category = DB::table('category_of_stacks')
                ->select('title')
                ->where(DB::raw('lower(title)'), 'like', '%' . strtolower($key) . '%')
                ->first();
            if (!$category) {
                $category = CategoryOfStack::create([
                    'title' => $key,
                ]);
            }
            foreach ($value as $stack_title) {
                $stack = DB::table('stacks')
                    ->select('title')
                    ->where(DB::raw('lower(title)'), 'like', '%' . strtolower($stack_title) . '%')
                    ->first();
                if (!$stack) {
                    $category->stacks()->create([
                        'title' => strtoupper($stack_title),
                    ]);
                }
            }
        }
    }
}
