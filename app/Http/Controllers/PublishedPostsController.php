<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Settings;

class PublishedPostsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): \Illuminate\View\View
    {
        return view('posts.index', [
            'posts' => Post::latest()->published()->paginate(10),
            'categories' => Settings::getCategories(),
        ]);
    }
}
