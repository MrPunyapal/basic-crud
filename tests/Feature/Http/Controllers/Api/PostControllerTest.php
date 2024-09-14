<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Api\PostController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );
});

it('can list all posts', function () {
    $posts = Post::factory()->count(3)->create();

    $this->getJson(action([PostController::class, 'index']))
        ->assertOk()
        ->assertJson(['data' => $posts->toArray()]);
});

it('can create a new post', function () {
    $data = Post::factory()->make()->toArray();

    $this->postJson(action([PostController::class, 'store']), $data)
        ->assertCreated();

    $this->assertDatabaseHas('posts', [
        'title' => $data['title'],
        'category_id' => $data['category_id'],
    ]);
});

it('can show a specific post', function () {
    $post = Post::factory()->create();

    $this->getJson(action([PostController::class, 'show'], $post))
        ->assertOk()
        ->assertJson(['data' => $post->toArray()]);
});

it('can update a post', function () {
    $post = Post::factory()->create();
    $data = Post::factory()->make()->toArray();

    $this->putJson(action([PostController::class, 'update'], $post), $data)
        ->assertOk();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => $data['title'],
        'category_id' => $data['category_id'],
    ]);
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    $this->deleteJson(action([PostController::class, 'destroy'], $post))
        ->assertNoContent();

    $this->assertSoftDeleted('posts', [
        'id' => $post->id,
    ]);
});
