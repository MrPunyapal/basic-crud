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

test('can only see published posts', function () {
    Post::factory(rand(1,5))->create([
        'published_at' => now()->addDay(),
    ]);
    Post::factory(rand(1,5))->create([
        'published_at' => now()->addDay(),
    ]);

    get(route('posts.index'))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHas('posts', fn ($posts) => $posts->where('published_at', '>=', now())->count() === 0);
});
