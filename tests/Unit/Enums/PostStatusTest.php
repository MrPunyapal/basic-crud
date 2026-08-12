<?php

declare(strict_types=1);

use App\Enums\PostStatus;

it('returns the correct label for Draft', function (): void {
    $status = PostStatus::Draft;
    $label = $status->label();

    expect($label)->toBe(__('posts.status.Draft'));
});

it('returns the correct label for Published', function (): void {
    $status = PostStatus::Published;
    $label = $status->label();

    expect($label)->toBe(__('posts.status.Published'));
});

it('returns the correct color for Draft', function (): void {
    $status = PostStatus::Draft;
    $color = $status->color();

    expect($color)->toBe('bg-yellow-500');
});

it('returns the correct color for Published', function (): void {
    $status = PostStatus::Published;
    $color = $status->color();

    expect($color)->toBe('bg-green-500');
});

it('returns the correct badge color for Draft', function (): void {
    $status = PostStatus::Draft;
    $badgeColor = $status->badgeColor();

    expect($badgeColor)->toBe('yellow');
});

it('returns the correct badge color for Published', function (): void {
    $status = PostStatus::Published;
    $badgeColor = $status->badgeColor();

    expect($badgeColor)->toBe('green');
});

it('returns the correct badge color', function (string $value, string $expected): void {
    expect(PostStatus::tryFrom($value)?->badgeColor())->toBe($expected);
})
    ->with([
        PostStatus::Draft->name => [
            'value' => PostStatus::Draft->value,
            'expected' => 'yellow',
        ],
        PostStatus::Published->name => [
            'value' => PostStatus::Published->value,
            'expected' => 'green',
        ],
    ]);
