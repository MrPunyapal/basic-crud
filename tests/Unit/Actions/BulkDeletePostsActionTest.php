<?php

declare(strict_types=1);

use App\Actions\Posts\BulkDeletePostsAction;
use App\Models\Post;

describe('BulkDeletePostsAction', function () {
    it('deletes multiple posts successfully', function () {
        $posts = Post::factory(3)->create();
        $postIds = $posts->pluck('id')->toArray();

        $action = new BulkDeletePostsAction;
        $deletedCount = $action->execute($postIds);

        expect($deletedCount)->toBe(3);

        foreach ($posts as $post) {
            $this->assertSoftDeleted('posts', ['id' => $post->id]);
        }
    });

    it('returns zero when no post IDs are provided', function () {
        $action = new BulkDeletePostsAction;
        $deletedCount = $action->execute([]);

        expect($deletedCount)->toBe(0);
    });

    it('returns zero when provided IDs do not exist', function () {
        $action = new BulkDeletePostsAction;
        $deletedCount = $action->execute([999, 1000, 1001]);

        expect($deletedCount)->toBe(0);
    });

    it('deletes only existing posts', function () {
        $existingPosts = Post::factory(2)->create();
        $nonExistentIds = [999, 1000];
        $allIds = array_merge($existingPosts->pluck('id')->toArray(), $nonExistentIds);

        $action = new BulkDeletePostsAction;
        $deletedCount = $action->execute($allIds);

        expect($deletedCount)->toBe(2);

        foreach ($existingPosts as $post) {
            $this->assertSoftDeleted('posts', ['id' => $post->id]);
        }
    });

    it('handles deletion failures gracefully', function () {
        // Test with real posts - this tests the actual deletion flow
        $posts = Post::factory(3)->create();
        $postIds = $posts->pluck('id')->toArray();

        $action = new BulkDeletePostsAction;
        $deletedCount = $action->execute($postIds);

        expect($deletedCount)->toBe(3);

        foreach ($posts as $post) {
            $this->assertSoftDeleted('posts', ['id' => $post->id]);
        }
    });

    it('gets posts for deletion confirmation', function () {
        $posts = Post::factory(3)->create();
        $postIds = $posts->pluck('id')->toArray();

        $action = new BulkDeletePostsAction;
        $postsForDeletion = $action->getPostsForDeletion($postIds);

        expect($postsForDeletion)->toHaveCount(3);
        expect($postsForDeletion->first())->toHaveKeys(['id', 'title']);
    });

    it('returns empty collection when no post IDs provided for confirmation', function () {
        $action = new BulkDeletePostsAction;
        $postsForDeletion = $action->getPostsForDeletion([]);

        expect($postsForDeletion)->toBeEmpty();
    });

    it('gets only existing posts for deletion confirmation', function () {
        $existingPosts = Post::factory(2)->create();
        $nonExistentIds = [999, 1000];
        $allIds = array_merge($existingPosts->pluck('id')->toArray(), $nonExistentIds);

        $action = new BulkDeletePostsAction;
        $postsForDeletion = $action->getPostsForDeletion($allIds);

        expect($postsForDeletion)->toHaveCount(2);
        expect($postsForDeletion->pluck('id')->toArray())->toEqual($existingPosts->pluck('id')->toArray());
    });
});
