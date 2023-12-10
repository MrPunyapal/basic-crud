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
        ->assertViewHas('posts', fn($posts) => $posts->where('published_at', '>=', now())->count() === 0);
});

test('can search posts by title', function () {

    [$postToSearch, $missingPost] = Post::factory(2)->create([
        'published_at' => now()->subDay(),
    ]);

    $searchTerm = $postToSearch->title;
    // Execute the search
    $response = $this->get(route('posts.published', ['search' => $searchTerm]));
    // Assertions
    $response->assertOk();
    $response->assertViewIs('posts.index');
    $response->assertViewHasAll([
        'categories',
        'posts',
    ]);

    // Check if the matching post is present in the view
    $response->assertSeeText($searchTerm);

    // Check if non-matching posts are not present in the view
    $response->assertDontSeeText($missingPost->title);
});