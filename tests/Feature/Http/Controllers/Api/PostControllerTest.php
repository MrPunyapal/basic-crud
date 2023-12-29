<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

it('can list all posts', function () {
    $posts = Post::factory()->count(3)->create();

    getJson('/api/posts')
        ->assertOk()
        ->assertJson($posts->toArray());
});

it('can create a new post', function () {
    $data = Post::factory()->make()->toArray();

    postJson('/api/posts', $data)
        ->assertCreated();

    assertDatabaseHas('posts', [
        'title' => $data['title'],
        'category_id' => $data['category_id'],
    ]);
});

it('can show a specific post', function () {
    $post = Post::factory()->create();

    getJson('/api/posts/'.$post->id)
        ->assertOk()
        ->assertJson($post->toArray());
});

it('can update a post', function () {
    $post = Post::factory()->create();
    $data = Post::factory()->make()->toArray();

    putJson('/api/posts/'.$post->id, $data)
        ->assertOk();

    assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => $data['title'],
        'category_id' => $data['category_id'],
    ]);
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    deleteJson('/api/posts/'.$post->id)
        ->assertNoContent();
});
