<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return JsonResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResource
    {
        return new JsonResource(Post::query()->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResource
    {
        return new JsonResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResource
    {
        $post->update($request->validated());

        return new JsonResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }
}
