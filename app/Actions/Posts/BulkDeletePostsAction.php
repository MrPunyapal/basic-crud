<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;

final class BulkDeletePostsAction
{
    /**
     * Execute bulk delete operation for multiple posts
     *
     * @param  array<mixed>  $postIds
     */
    public function execute(array $postIds): int
    {
        if ($postIds === []) {
            return 0;
        }

        $validPostIds = array_filter(array_map(function (mixed $id): int {
            if (is_numeric($id)) {
                return (int) $id;
            }

            return 0;
        }, $postIds));

        if ($validPostIds === []) {
            return 0;
        }

        $posts = Post::query()->whereIn('id', $validPostIds)->get();

        if ($posts->isEmpty()) {
            return 0;
        }

        $deletedCount = 0;

        foreach ($posts as $post) {
            if ($post->delete()) {
                $deletedCount++;
            }
        }

        return $deletedCount;
    }
}
