<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Enums\FeaturedStatus;
use App\Models\Post;

test('can feature a post', function () {
    $post = Post::factory()->create([
        'is_featured' => FeaturedStatus::NotFeatured,
    ]);

    $this->from(route('posts.index'))
        ->patch(route('posts.featured', $post))
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post featured successfully.');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_featured' => FeaturedStatus::Featured,
    ]);
});

test('can unfeature a post', function () {
    $post = Post::factory()->create([
        'is_featured' => FeaturedStatus::Featured,
    ]);

    $this->from(route('posts.show', ['post' => $post]))
        ->patch(route('posts.featured', ['post' => $post]))
        ->assertRedirect(route('posts.show', ['post' => $post]))
        ->assertSessionHas('success', 'Post unfeatured successfully.');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_featured' => FeaturedStatus::NotFeatured,
    ]);
});
