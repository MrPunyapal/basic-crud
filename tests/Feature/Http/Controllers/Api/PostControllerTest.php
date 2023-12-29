<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Api\PostController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );
});

it('can list all posts', function () {
    $posts = Post::factory()->count(3)->create();

    getJson(action([PostController::class, 'index']))
        ->assertOk()
        ->assertJson($posts->toArray());
});

it('can create a new post', function () {
    $data = Post::factory()->make()->toArray();

    postJson(action([PostController::class, 'store']), $data)
        ->assertCreated();

    assertDatabaseHas('posts', [
        'title' => $data['title'],
        'category_id' => $data['category_id'],
    ]);
});

it('can show a specific post', function () {
    $post = Post::factory()->create();

    getJson(action([PostController::class, 'show'], $post))
        ->assertOk()
        ->assertJson($post->toArray());
});

it('can update a post', function () {
    $post = Post::factory()->create();
    $data = Post::factory()->make()->toArray();

    putJson(action([PostController::class, 'update'], $post), $data)
        ->assertOk();

    assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => $data['title'],
        'category_id' => $data['category_id'],
    ]);
});

it('can delete a post', function () {
    $post = Post::factory()->create();

    deleteJson(action([PostController::class, 'destroy'], $post))
        ->assertNoContent();

    assertSoftDeleted('posts', [
        'id' => $post->id,
    ]);
});
