<?php

declare(strict_types=1);
use App\Models\Post;

test('null in image attribute', function () {
    $post = Post::factory()->create([
        'image' => null,
    ]);

    expect($post->image)->toBeNull();
});

test('null in image attribute with image', function () {
    $post = Post::factory()->create([
        'image' => 'image.jpg',
    ]);

    expect($post->image)->toBeUrl();
});
