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

test('can see posts sorted by title', function (string $direction) {
    $posts = Post::factory(3)
        ->sequence(
            ['title' => 'abc', 'published_at' => now()->subDays(1)],
            ['title' => 'bcd', 'published_at' => now()->subDays(2)],
            ['title' => 'cde', 'published_at' => now()->subDays(3)],
        )
        ->create();

    $expectedSortedPosts = ($direction === 'asc')
        ? $posts->pluck('title')->all()
        : $posts->pluck('title')->reverse()->all();

    get(route('posts.published', [
        'sortBy' => 'title',
        'direction' => $direction,
    ]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'categories',
            'posts',
        ])
        ->assertSeeTextInOrder($expectedSortedPosts);
})->with(['asc', 'desc']);

test('can see posts if sort column name is invalid', function () {
    Post::factory(10)->create();

    get(route('posts.published', [
        'sortBy' => 'category',
        'direction' => 'asc',
    ]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'categories',
            'posts',
        ]);
});

test('can see posts if direction name is invalid', function () {

    Post::factory(10)->create();

    get(route('posts.published', [
        'sortBy' => 'title',
        'direction' => 'ascending',
    ]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'categories',
            'posts',
        ]);

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
