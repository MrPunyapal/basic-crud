<?php

declare(strict_types=1);

use App\Actions\Posts\UpdatePostAction;
use App\Models\Post;

test('it can update a post', function (): void {
    $post = Post::factory()->create();
    $updateData = [
        'title' => 'Updated Title',
        'content' => 'Updated content',
    ];

    $result = (new UpdatePostAction)->execute($post, $updateData);

    expect($result)->toBeTrue();
    expect($post->fresh())
        ->title->toBe('Updated Title')
        ->content->toContain('Updated content');
});
