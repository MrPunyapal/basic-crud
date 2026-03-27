<?php

declare(strict_types=1);
use App\Models\Category;
use App\Models\Post;

test('it gets posts from relation', function (): void {
    $category = Category::factory()->create();
    $posts = Post::factory()->count(3)->create([
        'category_id' => $category->id,
    ]);

    $categoryPosts = $category->posts;

    expect($categoryPosts)->toHaveCount(3)
        ->and($categoryPosts->first()?->title)->toBe($posts->first()?->title)
        ->and($categoryPosts->last()?->title)->toBe($posts->last()?->title);
});
