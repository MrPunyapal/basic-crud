<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

test('root redirects to posts', function() {
    $this
        ->get('/')
        ->assertRedirect(route('posts.index'));
});

test('can see posts', function() {
    $this
        ->get(route('posts.index'))
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHas('posts')
        ->assertViewHas('categories')
        ->assertViewHas('tags');
});

test('can see create post page', function() {
    $this
        ->get(route('posts.create'))
        ->assertOk()
        ->assertViewIs('posts.create')
        ->assertViewHas('categories')
        ->assertViewHas('tags');
});

test('can create post', function() {
    $image = UploadedFile::fake()->image('some-image.png');

    $this
        ->post(route('posts.store'), [
            'title' => 'Test Title',
            'slug' => 'test-title',
            'content' => 'Test Content',
            'image' => $image,
            'category' => ['Laravel'],
            'description' => 'this is the description',
            'body' => 'this is the body',
            'tags' => ['Eloquent'],
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Title'
    ]);
});

test('cannot create post with invalid data', function() {
    $this
        ->post(route('posts.store'), [])
        ->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'slug',
            'category',
            'description',
            'body'
        ])
        ->assertRedirect();
});

test('can see post page', function() {
    $post = Post::factory()->create();

    $this
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertViewIs('posts.show')
        ->assertViewHas('post')
        ->assertViewHas('categories')
        ->assertViewHas('tags');
});

test('can see edit post page', function() {
    $post = Post::factory()->create();

    $this
        ->get(route('posts.edit', $post))
        ->assertOk()
        ->assertViewIs('posts.edit')
        ->assertViewHas('post')
        ->assertViewHas('categories')
        ->assertViewHas('tags');
});

test('can edit post', function() {
    $post = Post::factory()->create();

    $image = UploadedFile::fake()->image('some-image.png');

    $this
        ->patch(route('posts.update', $post), [
            'title' => 'updated Title',
            'slug' => 'test-title',
            'content' => 'Test Content',
            'image' => $image,
            'category' => ['Laravel'],
            'description' => 'this is the description',
            'body' => 'this is the body',
            'tags' => ['Eloquent'],
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseHas('posts', [
        'title' => 'updated Title'
    ]);
});

test('can delete post', function() {
    $post = Post::factory()->create();

    $this
        ->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));
});