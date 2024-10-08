<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\FeaturedStatus;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class FeaturedPostController extends Controller
{
    public function __invoke(Post $post): RedirectResponse
    {
        $isFeatured = $post->is_featured === FeaturedStatus::Featured;
        $post->update([
            'is_featured' => $isFeatured
                ? FeaturedStatus::NotFeatured
                : FeaturedStatus::Featured,
        ]);

        return back()->with('success', __('posts.messages.Post '.($isFeatured ? 'unfeatured' : 'featured').' successfully'));
    }
}
