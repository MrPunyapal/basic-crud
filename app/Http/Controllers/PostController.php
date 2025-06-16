<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Posts\CreatePostAction;
use App\Actions\Posts\DeletePostAction;
use App\Actions\Posts\UpdatePostAction;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Support\QueryResolver;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->select('id', 'title', 'is_featured', 'category_id', 'description', 'created_at', 'updated_at')
            ->withAggregate('category', 'title')
            ->filter($request->fluent())
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
    public function store(StorePostRequest $request, CreatePostAction $action): RedirectResponse
    {
        $action->execute($request->validated());

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
    public function update(UpdatePostRequest $request, Post $post, UpdatePostAction $action): RedirectResponse
    {
        $action->execute($post, $request->validated());

        return to_route('posts.index', QueryResolver::getPreviousQuery('posts.index'))
            ->with('success', __('posts.messages.Post updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, DeletePostAction $action): RedirectResponse
    {
        $action->execute($post);

        return to_route('posts.index', QueryResolver::getPreviousQuery('posts.index'))
            ->with('success', __('posts.messages.Post deleted successfully'));
    }
}
