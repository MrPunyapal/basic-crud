<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\FeaturedStatus;
use App\Models\Post;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;

test('can feature a post', function () {
    $post = Post::factory()->create([
        'is_featured' => FeaturedStatus::NOT_FEATURED,
    ]);

    from(route('posts.index'))
        ->patch(route('posts.featured', $post))
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post featured successfully.');

    assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_featured' => FeaturedStatus::FEATURED,
    ]);
});

test('can unfeature a post', function () {
    $post = Post::factory()->create([
        'is_featured' => FeaturedStatus::FEATURED,
    ]);

    from(route('posts.show', ['post' => $post]))
        ->patch(route('posts.featured', ['post' => $post]))
        ->assertRedirect(route('posts.show', ['post' => $post]))
        ->assertSessionHas('success', 'Post unfeatured successfully.');

    assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_featured' => FeaturedStatus::NOT_FEATURED,
    ]);
});
