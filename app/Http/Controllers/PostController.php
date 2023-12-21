<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\PostSortColumnsEnum;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Support\Settings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('posts.index', [
            'posts' => Post::query()
                ->select('id', 'title', 'is_featured', 'category_id', 'created_at', 'updated_at')
                ->withAggregate('category', 'title')
                ->search($request->input('search').'')
                ->when($request->input('published'), fn (Builder|Post $query) => $query->published())
                ->when(
                    in_array($request->input('sortBy'), PostSortColumnsEnum::columns(), true),
                    fn (Builder|Post $query) => $query->sortBy($request->input('sortBy').'', $request->input('direction').''),
                    fn (Builder|Post $query) => $query->latest(),
                )
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('posts.create', [
            'categories' => Category::pluck('title', 'id'),
            'tags' => Settings::getTags(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        Post::create($request->validated());

        return to_route('posts.index')->with('success', __('posts.messages.Post created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post->loadAggregate('category', 'title'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::pluck('title', 'id'),
            'tags' => Settings::getTags(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        return to_route('posts.index')->with('success', __('posts.messages.Post updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return to_route('posts.index')->with('success', __('posts.messages.Post deleted successfully'));
    }
}
