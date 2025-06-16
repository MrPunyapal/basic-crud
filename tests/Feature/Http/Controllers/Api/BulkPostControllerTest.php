<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

it('can bulk delete posts via API', function (): void {
    $posts = Post::factory()->count(3)->create();
    $postIds = $posts->pluck('id')->toArray();

    $response = $this->deleteJson('/api/posts/bulk', [
        'post_ids' => $postIds,
    ]);

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'message' => '3 posts deleted successfully.',
            'data' => [
                'deleted_count' => 3,
                'post_ids' => $postIds,
            ],
        ]);

    foreach ($postIds as $postId) {
        $this->assertSoftDeleted('posts', ['id' => $postId]);
    }
});

it('validates required post_ids field via API', function (): void {
    $response = $this->deleteJson('/api/posts/bulk', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['post_ids']);
});

it('validates invalid post IDs via API', function (): void {
    $response = $this->deleteJson('/api/posts/bulk', [
        'post_ids' => [999, 1000],
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['post_ids.0', 'post_ids.1']);
});

it('requires authentication for API bulk operations', function (): void {
    $this->app['auth']->forgetGuards();
    $posts = Post::factory()->count(2)->create();

    $response = $this->deleteJson('/api/posts/bulk', [
        'post_ids' => $posts->pluck('id')->toArray(),
    ]);

    $response->assertUnauthorized();
});

it('handles single post deletion message via API', function (): void {
    $post = Post::factory()->create();

    $response = $this->deleteJson('/api/posts/bulk', [
        'post_ids' => [$post->id],
    ]);

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Post deleted successfully.',
            'data' => [
                'deleted_count' => 1,
                'post_ids' => [$post->id],
            ],
        ]);

    $this->assertSoftDeleted('posts', ['id' => $post->id]);
});
