<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Api\PostController;
use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

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

it('returns filtered posts based on search parameter', function () {
    $user = User::factory()->create();
    $postA = Post::factory()->create([
        'title' => 'Test Post A',
        'published_at' => now()->subDay(),
    ]);
    $postB = Post::factory()->create([
        'title' => 'Another Post B',
        'published_at' => now()->addDay(),
    ]);

    $response = $this->actingAs($user)
        ->getJson(action([PostController::class, 'index'], ['search' => 'Test']))
        ->assertSuccessful();

    expect($response->json('data'))->toHaveCount(1);
    expect($response->json('data.0.id'))->toBe($postA->id);
});

it('returns filtered posts based on published parameter', function () {
    $user = User::factory()->create();
    $postA = Post::factory()->create([
        'title' => 'Test Post A',
        'published_at' => now()->subDay(),
    ]);
    $postB = Post::factory()->create([
        'title' => 'Another Post B',
        'published_at' => now()->addDay(),
    ]);

    $response = $this->actingAs($user)
        ->getJson(action([PostController::class, 'index'], ['published' => true]))
        ->assertSuccessful();

    expect($response->json('data'))->toHaveCount(1);
    expect($response->json('data.0.id'))->toBe($postA->id);
});

it('can sort posts by specified column and direction', function () {
    $user = User::factory()->create();
    $postA = Post::factory()->create([
        'title' => 'Test Post A',
        'published_at' => now()->subDay(),
    ]);
    $postB = Post::factory()->create([
        'title' => 'Another Post B',
        'published_at' => now()->addDay(),
    ]);

    $response = $this->actingAs($user)
        ->getJson(action([PostController::class, 'index'], ['sortBy' => 'title', 'direction' => 'asc']))
        ->assertSuccessful();

    expect($response->json('data'))->toHaveCount(2);
    expect($response->json('data.0.id'))->toBe($postB->id);
    expect($response->json('data.1.id'))->toBe($postA->id);
});

it('returns posts with default sorting when sort column is invalid', function () {
    $user = User::factory()->create();
    $postA = Post::factory()->create([
        'title' => 'Test Post A',
        'published_at' => now()->subDay(),
    ]);
    $postB = Post::factory()->create([
        'title' => 'Another Post B',
        'published_at' => now()->addDay(),
    ]);

    $response = $this->actingAs($user)
        ->getJson(action([PostController::class, 'index'], ['sortBy' => 'invalid_column']))
        ->assertSuccessful();

    expect($response->json('data'))->toHaveCount(2);
});

it('combines multiple filter parameters', function () {
    $user = User::factory()->create();
    $postA = Post::factory()->create([
        'title' => 'Test Post A',
        'published_at' => now()->subDay(),
    ]);
    $postB = Post::factory()->create([
        'title' => 'Another Post B',
        'published_at' => now()->addDay(),
    ]);
    $postC = Post::factory()->create([
        'title' => 'Test Post C',
        'published_at' => now()->subDay(),
    ]);

    $response = $this->actingAs($user)
        ->getJson(action([PostController::class, 'index'], [
            'search' => 'Test',
            'published' => true,
        ]))
        ->assertSuccessful();

    expect($response->json('data'))->toHaveCount(2);
    expect(collect($response->json('data'))->pluck('id')->toArray())
        ->toContain($postA->id, $postC->id)
        ->not->toContain($postB->id);
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
