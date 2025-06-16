<?php

declare(strict_types=1);

use App\Models\Post;

it('can bulk delete posts', function () {
    $posts = Post::factory(3)->create();
    $postIds = $posts->pluck('id')->toArray();

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $postIds,
    ]);

    $response
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', '3 posts deleted successfully.');

    foreach ($posts as $post) {
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
});

it('can bulk delete single post', function () {
    $post = Post::factory()->create();

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => [$post->id],
    ]);

    $response
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post deleted successfully.');

    $this->assertSoftDeleted('posts', ['id' => $post->id]);
});

it('shows validation error when posts do not exist', function () {
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => [999, 1000], // Non-existent IDs
    ]);

    $response
        ->assertSessionHasErrors(['post_ids.0', 'post_ids.1'])
        ->assertSessionHasErrorsIn('default', [
            'post_ids.0' => 'One or more selected posts do not exist.',
            'post_ids.1' => 'One or more selected posts do not exist.',
        ]);
});

it('validates required post_ids field', function () {
    $response = $this->delete(route('posts.bulk-destroy'), []);

    $response
        ->assertSessionHasErrors(['post_ids'])
        ->assertSessionHasErrorsIn('default', [
            'post_ids' => 'Please select at least one post to delete.',
        ]);
});

it('validates post_ids must be array', function () {
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => 'not-an-array',
    ]);

    $response
        ->assertSessionHasErrors(['post_ids'])
        ->assertSessionHasErrorsIn('default', [
            'post_ids' => 'Invalid post selection.',
        ]);
});

it('validates post_ids array must not be empty', function () {
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => [],
    ]);

    $response
        ->assertSessionHasErrors(['post_ids'])
        ->assertSessionHasErrorsIn('default', [
            'post_ids' => 'Please select at least one post to delete.',
        ]);
});

it('validates post_ids must contain valid integers', function () {
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => ['not-an-integer', 'also-not-integer'],
    ]);

    $response
        ->assertSessionHasErrors(['post_ids.0', 'post_ids.1']);
});

it('validates post_ids must exist in database', function () {
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => [999, 1000], // Non-existent IDs
    ]);

    $response
        ->assertSessionHasErrors(['post_ids.0', 'post_ids.1'])
        ->assertSessionHasErrorsIn('default', [
            'post_ids.0' => 'One or more selected posts do not exist.',
            'post_ids.1' => 'One or more selected posts do not exist.',
        ]);
});

it('preserves query parameters after bulk delete', function () {
    $posts = Post::factory(2)->create();
    $postIds = $posts->pluck('id')->toArray();

    // First, visit the posts index with query parameters
    $this->get(route('posts.index', ['search' => 'test', 'sort' => 'title']))
        ->assertOk();

    // Then perform bulk delete
    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $postIds,
    ]);

    // Should redirect back with the same query parameters
    $response
        ->assertRedirect(route('posts.index', ['search' => 'test', 'sort' => 'title']))
        ->assertSessionHas('success');
});

it('handles partial deletion gracefully', function () {
    $existingPosts = Post::factory(2)->create();
    $nonExistentIds = [999];
    $allIds = array_merge($existingPosts->pluck('id')->toArray(), $nonExistentIds);

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $allIds,
    ]);

    // Should fail validation due to non-existent ID
    $response->assertSessionHasErrors(['post_ids.2']);
});

it('bulk delete respects soft delete', function () {
    $posts = Post::factory(3)->create();
    $postIds = $posts->pluck('id')->toArray();

    $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $postIds,
    ]);

    // Posts should be soft deleted, not hard deleted
    foreach ($posts as $post) {
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
});

it('handles edge case where no posts are actually deleted despite validation', function () {
    // This is a theoretical edge case that might happen if posts are deleted
    // between validation and execution
    $posts = Post::factory(2)->create();
    $postIds = $posts->pluck('id')->toArray();

    // Delete the posts before the bulk delete request
    Post::whereIn('id', $postIds)->forceDelete();

    $response = $this->delete(route('posts.bulk-destroy'), [
        'post_ids' => $postIds,
    ]);

    // This should trigger validation error since posts no longer exist
    $response->assertSessionHasErrors(['post_ids.0', 'post_ids.1']);
});
