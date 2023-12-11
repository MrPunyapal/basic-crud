<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Settings;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublishedPostsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('posts.index', [
            'posts' => Post::search($request->input('search'))
                ->sortBy($request->input('sortBy'), $request->input('direction'))
                ->published()
                ->paginate(10)
                ->withQueryString(),
            'categories' => Settings::getCategories(),
        ]);
    }
}
