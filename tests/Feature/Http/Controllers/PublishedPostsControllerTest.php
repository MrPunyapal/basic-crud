<?php

namespace Tests\Feature;

use App\Models\Post;

use function Pest\Laravel\get;

test('can only see published posts', function () {
    Post::factory(rand(1, 5))->create([
        'published_at' => now()->addDay(),
    ]);
    Post::factory(rand(1, 5))->create([
        'published_at' => now()->subDay(),
    ]);

    get(route('posts.published'))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHas('posts', fn ($posts) => $posts->where('published_at', '>=', now())->count() === 0);
});
