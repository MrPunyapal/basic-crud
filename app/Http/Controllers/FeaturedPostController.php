<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Posts\TogglePostFeatureAction;
use App\Enums\FeaturedStatus;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class FeaturedPostController extends Controller
{
    public function __invoke(Post $post, TogglePostFeatureAction $action): RedirectResponse
    {
        $isFeatured = $post->is_featured === FeaturedStatus::Featured;
        $action->execute($post);

        return back()->with('success', __('posts.messages.Post '.($isFeatured ? 'unfeatured' : 'featured').' successfully'));
    }
}
