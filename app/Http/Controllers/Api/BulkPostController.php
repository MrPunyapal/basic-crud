<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Posts\BulkDeletePostsAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * API Controller for handling bulk operations on posts
 */
final class BulkPostController
{
    /**
     * Bulk delete multiple posts
     */
    public function destroy(Request $request, BulkDeletePostsAction $action): JsonResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate([
            'post_ids' => ['required', 'array', 'min:1'],
            'post_ids.*' => ['integer', 'exists:posts,id'],
        ], [
            'post_ids.required' => 'Please select at least one post to delete.',
            'post_ids.array' => 'Invalid post selection.',
            'post_ids.min' => 'Please select at least one post to delete.',
            'post_ids.*.integer' => 'Invalid post ID.',
            'post_ids.*.exists' => 'One or more selected posts do not exist.',
        ]);

        /** @var array<mixed> $postIds */
        $postIds = $validated['post_ids'];
        $deletedCount = $action->execute($postIds);

        $message = $deletedCount === 1
            ? 'Post deleted successfully.'
            : $deletedCount.' posts deleted successfully.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'deleted_count' => $deletedCount,
                'post_ids' => $postIds,
            ],
        ]);
    }
}
