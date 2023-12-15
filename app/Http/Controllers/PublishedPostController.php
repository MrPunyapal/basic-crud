<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PublishedPostController extends Controller
{
    public function __invoke(Post $post)
    {
        $post->update([
            'published_at' => is_null($post->published_at) ? now() : null,
        ]);

        return back()->with('success', 'Post published successfully.');
    }
}
