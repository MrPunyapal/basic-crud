<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;
use Illuminate\Support\Collection;

final class BulkDeletePostsAction
{
    /**
     * Execute bulk delete operation for multiple posts
     *
     * @param  array<mixed>  $postIds
     * @return int Number of deleted posts
     */
    public function execute(array $postIds): int
    {
        if ($postIds === []) {
            return 0;
        }

        // Convert to integers and filter out invalid values
        $validPostIds = array_filter(array_map(function (mixed $id): int {
            if (is_numeric($id)) {
                return (int) $id;
            }

            return 0;
        }, $postIds));

        if ($validPostIds === []) {
            return 0;
        }

        // Get the posts that exist and user can delete
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

    /**
     * Get posts that will be deleted for confirmation
     *
     * @param  array<mixed>  $postIds
     * @return Collection<int, Post>
     */
    public function getPostsForDeletion(array $postIds): Collection
    {
        if ($postIds === []) {
            return new Collection;
        }

        // Convert to integers and filter out invalid values
        $validPostIds = array_filter(array_map(function (mixed $id): int {
            if (is_numeric($id)) {
                return (int) $id;
            }

            return 0;
        }, $postIds));

        if ($validPostIds === []) {
            return new Collection;
        }

        return Post::query()->whereIn('id', $validPostIds)
            ->select('id', 'title')
            ->get();
    }
}
