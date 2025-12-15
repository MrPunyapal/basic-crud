<?php

declare(strict_types=1);

use App\Actions\Posts\TogglePostFeatureAction;
use App\Enums\FeaturedStatus;
use App\Models\Post;

it('toggles a post feature', function (): void {
    $post = Post::factory()->create([
        'is_featured' => FeaturedStatus::NotFeatured,
    ]);

    $action = new TogglePostFeatureAction;
    $action->execute($post);

    expect($post->refresh()->is_featured)->toBe(FeaturedStatus::Featured);
});

it('toggles a post feature off', function (): void {
    $post = Post::factory()->create(['is_featured' => FeaturedStatus::Featured]);

    $action = new TogglePostFeatureAction;
    $action->execute($post);

    expect($post->refresh()->is_featured)->toBe(FeaturedStatus::NotFeatured);
});
