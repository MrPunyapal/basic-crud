<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can bulk delete posts via web', function (): void {
    $posts = Post::factory()->count(3)->create();
    $postIds = $posts->pluck('id')->toArray();

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $postIds,
    ]);

    $response->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', '3 posts deleted successfully.');

    foreach ($postIds as $postId) {
        $this->assertSoftDeleted('posts', ['id' => $postId]);
    }
});

it('validates required post_ids field via web', function (): void {
    $response = $this->delete(route('posts.bulk-destroy'), []);

    $response->assertSessionHasErrors(['post_ids']);
});

it('validates invalid post IDs via web', function (): void {
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => [999, 1000],
    ]);

    $response->assertSessionHasErrors(['post_ids.0', 'post_ids.1']);
});

it('preserves query parameters when redirecting', function (): void {
    $post = Post::factory()->create();

    $this->session(['posts.index.previous.query' => ['search' => 'test', 'sort' => 'title']]);

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => [$post->id],
    ]);

    $response->assertRedirect(route('posts.index', ['search' => 'test', 'sort' => 'title']));
});

it('requires authentication for web bulk operations', function (): void {
    $this->app['auth']->logout();
    $posts = Post::factory()->count(2)->create();

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $posts->pluck('id')->toArray(),
    ]);

    $response->assertStatus(302);
});
