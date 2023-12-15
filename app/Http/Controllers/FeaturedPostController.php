<?php

namespace App\Http\Controllers;

use App\Enums\FeaturedStatus;
use App\Models\Post;

class FeaturedPostController extends Controller
{
    public function __invoke(Post $post)
    {
        $isFeatured = $post->is_featured === FeaturedStatus::FEATURED;
        $post->update([
            'is_featured' => $isFeatured
                ? FeaturedStatus::NOT_FEATURED
                : FeaturedStatus::FEATURED,
        ]);

        return back()->with('success', 'Post '.($isFeatured ? 'unfeatured' : 'featured').' successfully.');
    }
}
