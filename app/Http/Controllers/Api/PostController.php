<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): \Illuminate\Http\JsonResponse
    {
        $post = Post::create($request->validated());

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): \Illuminate\Http\JsonResponse
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): \Illuminate\Http\JsonResponse
    {
        $post->update($request->validated());

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): \Illuminate\Http\JsonResponse
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
