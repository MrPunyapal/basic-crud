<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Builders\PostBuilder;
use App\Enums\PostSortColumnsEnum;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Support\QueryResolver;
use App\Support\Settings;
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
        $posts = Post::query()
            ->select('id', 'title', 'is_featured', 'category_id', 'created_at', 'updated_at')
            ->withAggregate('category', 'title')
            ->when((string) $request->string('search'), function (PostBuilder $query, string $search): void {
                $query->search($search);
            })
            ->when($request->input('published'), fn (PostBuilder $query): PostBuilder => $query->published())
            ->when(
                in_array($request->input('sortBy'), PostSortColumnsEnum::columns(), true),
                function (PostBuilder $query) use ($request): void {
                    $query->sortBy((string) $request->string('sortBy'), (string) $request->string('direction'));
                },
                fn (PostBuilder $query) => $query->latest(),
            )
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('posts.create', [
            'categories' => Category::query()->pluck('title', 'id'),
            'tags' => Settings::getTags(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        Post::query()->create($request->validated());

        return to_route('posts.index', QueryResolver::getPreviousQuery('posts.index'))
            ->with('success', __('posts.messages.Post created successfully'));
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
            'categories' => Category::query()->pluck('title', 'id'),
            'tags' => Settings::getTags(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        return to_route('posts.index', QueryResolver::getPreviousQuery('posts.index'))
            ->with('success', __('posts.messages.Post updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return to_route('posts.index', QueryResolver::getPreviousQuery('posts.index'))
            ->with('success', __('posts.messages.Post deleted successfully'));
    }
}
