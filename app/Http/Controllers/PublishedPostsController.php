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
        $search = $request->input('search');

        return view('posts.index', [
            'posts' => Post::query()
            ->sortBy(
                in_array($request->input('sortBy'), ['title']) ? $request->input('sortBy') : null,
                in_array($request->input('direction'), ['asc','desc']) ? $request->input('direction') : 'asc',
            )
            ->search($search)
            ->published()
            ->paginate(10)
            ->withQueryString(),
            'categories' => Settings::getCategories(),
        ]);
    }
}
