<?php

namespace App\Http\Controllers;

use App\Models\Post;

class FeaturedPostController extends Controller
{
    public function __invoke(Post $post)
    {
        $post->update([
            'is_featured' => !$post->is_featured,
        ]);

        return back()->with('success', 'Post '.($post->is_featured ? 'unfeatured' : 'featured').' successfully.');
    }
}
