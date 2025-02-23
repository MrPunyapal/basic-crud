<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;

final class UpdatePostAction
{
    /**
     * Update a post.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(Post $post, array $data): bool
    {
        return $post->update($data);
    }
}
