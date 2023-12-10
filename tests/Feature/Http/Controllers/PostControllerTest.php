<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

test('root redirects to posts', function () {
    get('/')
        ->assertRedirect(route('posts.index'));
});

test('can see posts', function () {
    get(route('posts.index'))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'categories',
            'posts',
        ]);
});

test('can see posts sorted by title', function (string $direction) {
    $posts = Post::factory(3)
        ->sequence(
            ['title' => 'abc'],
            ['title' => 'bcd'],
            ['title' => 'cde'],
        )
        ->create();

    $expectedSortedPosts = ($direction === 'asc')
        ? $posts->pluck('title')->all()
        : $posts->pluck('title')->reverse()->all();

    get(route('posts.index', [
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

test('can see posts sorted by invalid column', function () {
    Post::factory(10)->create();

    get(route('posts.index', [
        'sortBy' => 'invalid-column',
    ]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'categories',
            'posts',
        ]);
});

test('can search posts by title', function () {
    // Create test data
    [$postToSearch, $missingPost] = Post::factory(2)->create();

    $searchTerm = $postToSearch->title;

    // Execute the search
    get(route('posts.index', ['search' => $searchTerm]))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'categories',
            'posts',
        ])
        // Check if the matching post is present in the view
        ->assertSeeText($searchTerm)
        // Check if non-matching posts are not present in the view
        ->assertDontSeeText($missingPost->title);
});

test('can see create post page', function () {
    get(route('posts.create'))
        ->assertOk()
        ->assertViewIs('posts.create')
        ->assertViewHasAll([
            'categories',
            'tags',
        ]);
});

test('can create post', function () {
    $image = UploadedFile::fake()->image('some-image.png');

    post(route('posts.store'), [
        'title' => 'Test Title',
        'slug' => 'test-title',
        'content' => 'Test Content',
        'image' => $image,
        'category' => 1,
        'description' => 'this is the description',
        'body' => 'this is the body',
        'tags' => ['Eloquent'],
    ])
        ->assertRedirect(route('posts.index'))
        ->assertSessionHasNoErrors();

    assertDatabaseHas('posts', [
        'title' => 'Test Title',
    ]);
});

test('cannot create post with invalid data', function () {
    post(route('posts.store'), [])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'slug',
            'category',
            'description',
            'body',
        ]);
});

test('can see post page', function () {
    $post = Post::factory()->create();

    get(route('posts.show', $post))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertViewHasAll([
            'categories',
            'post',
        ]);
});

test('can see edit post page', function () {
    $post = Post::factory()->create();

    get(route('posts.edit', $post))
        ->assertOk()
        ->assertViewIs('posts.edit')
        ->assertViewHas([
            'post',
            'categories',
            'tags',
        ]);
});

test('can edit post', function () {
    $post = Post::factory()->create();

    $image = UploadedFile::fake()->image('some-image.png');

    patch(route('posts.update', $post), [
        'title' => 'updated Title',
        'slug' => 'test-title',
        'content' => 'Test Content',
        'image' => $image,
        'category' => 1,
        'description' => 'this is the description',
        'body' => 'this is the body',
        'tags' => ['Eloquent'],
    ])
        ->assertRedirect(route('posts.index'))
        ->assertSessionHasNoErrors();

    assertDatabaseHas('posts', [
        'title' => 'updated Title',
    ]);
});

test('can delete post', function () {
    $post = Post::factory()->createOne();

    delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    assertSoftDeleted($post);
});
