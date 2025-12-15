<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

test('null in image attribute', function (): void {
    $post = Post::factory()->create([
        'image' => null,
    ]);

    expect($post->image)->toBeNull();
});

test('null in image attribute with image', function (): void {
    $post = Post::factory()->create([
        'image' => 'image.jpg',
    ]);

    expect($post->image)->toBe(Storage::disk('public')->url('image.jpg'));
});
