<?php

declare(strict_types=1);

use App\Http\Controllers\Api\BulkPostController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Bulk operations for posts (must come BEFORE resource routes)
    Route::delete('/posts/bulk', [BulkPostController::class, 'destroy'])->name('api.posts.bulk.destroy');

    Route::apiResource('posts', PostController::class);
    // similar to:
    // Route::get('/posts', [PostController::class, 'index']);
    // Route::post('/posts', [PostController::class, 'store']);
    // Route::get('/posts/{post}', [PostController::class, 'show']);
    // Route::put('/posts/{post}', [PostController::class, 'update']);
    // Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});
