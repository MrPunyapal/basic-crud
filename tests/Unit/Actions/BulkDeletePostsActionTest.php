<?php

declare(strict_types=1);

use App\Actions\Posts\BulkDeletePostsAction;
use App\Models\Post;

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

it('handles edge cases for execution', function () {
    $action = new BulkDeletePostsAction;

    expect($action->execute([]))->toBe(0);
    expect($action->execute([999, 1000]))->toBe(0);
    expect($action->execute(['invalid', null]))->toBe(0);
});

it('deletes only existing posts from mixed input', function () {
    $existingPosts = Post::factory(2)->create();
    $mixedIds = array_merge($existingPosts->pluck('id')->toArray(), [999, 'invalid']);

    $action = new BulkDeletePostsAction;
    $deletedCount = $action->execute($mixedIds);

    expect($deletedCount)->toBe(2);

    foreach ($existingPosts as $post) {
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
});
