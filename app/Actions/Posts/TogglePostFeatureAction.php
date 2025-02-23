<?php

declare(strict_types=1);

namespace App\Actions\Posts;

use App\Enums\FeaturedStatus;
use App\Models\Post;

class TogglePostFeatureAction
{
    public function execute(Post $post): bool
    {
        return $post->update([
            'is_featured' => $post->is_featured === FeaturedStatus::Featured
                ? FeaturedStatus::NotFeatured
                : FeaturedStatus::Featured,
        ]);
    }
}
