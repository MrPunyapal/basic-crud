<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Post::query()->truncate();
        Category::query()->truncate();

        Category::factory(10)->sequence([
            ['title' => 'Laravel'],
            ['title' => 'PHP'],
            ['title' => 'JavaScript'],
            ['title' => 'Vue.js'],
            ['title' => 'React.js'],
            ['title' => 'Angular.js'],
            ['title' => 'Java'],
            ['title' => 'C#'],
        ])->has(
            Post::factory()->count(rand(5, 10))
        )->create();
    }
}
