<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Models\Post;

final class DeletePostAction
{
    public function execute(Post $post): bool
    {
        return (bool) $post->delete();
    }
}
