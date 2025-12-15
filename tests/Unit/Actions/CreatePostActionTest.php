<?php

declare(strict_types=1);

use App\Actions\Posts\CreatePostAction;
use App\Models\Category;
use App\Models\Post;

test('it can create a post', function (): void {
    $category = Category::factory()->create();
    $postData = Post::factory()->make([
        'category_id' => $category->id,
    ])->toArray();

    $post = (new CreatePostAction)->execute($postData);

    expect($post)
        ->toBeInstanceOf(Post::class)
        ->title->toBe($postData['title'])
        ->content->toBe($postData['content']);
});
