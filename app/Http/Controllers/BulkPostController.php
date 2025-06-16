<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Posts\BulkDeletePostsAction;
use App\Support\QueryResolver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controller for handling bulk operations on posts
 */
final class BulkPostController extends Controller
{
    /**
     * Bulk delete multiple posts
     */
    public function destroy(Request $request, BulkDeletePostsAction $action): RedirectResponse
    {
        /** @var array{post_ids: array<int>} $validated */
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

        $postIds = $validated['post_ids'];
        $deletedCount = $action->execute($postIds);

        $message = $deletedCount === 1
            ? __('posts.messages.Post deleted successfully')
            : __('posts.messages.:count posts deleted successfully', ['count' => $deletedCount]);

        return to_route('posts.index', QueryResolver::getPreviousQuery('posts.index'))
            ->with('success', $message);
    }
}
