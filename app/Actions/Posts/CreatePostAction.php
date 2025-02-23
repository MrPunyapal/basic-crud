<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;

class CreatePostAction
{
    /**
     * Create a new post.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Post
    {
        return Post::query()->create($data);
    }
}
