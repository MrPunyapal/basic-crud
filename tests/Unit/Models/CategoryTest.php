<?php

declare(strict_types=1);
use App\Models\Category;
use App\Models\Post;

test('it gets posts from relation', function (): void {
    $category = Category::factory()->create();
    $posts = Post::factory()->count(3)->create([
        'category_id' => $category->id,
    ]);

    expect($category->posts->count())->toBe(3);
    expect($category->posts->first()->title)->toBe($posts->first()->title);
    expect($category->posts->last()->title)->toBe($posts->last()->title);
});
