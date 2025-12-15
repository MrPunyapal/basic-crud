<?php

declare(strict_types=1);

use App\Enums\FeaturedStatus;

it('returns the correct label for NotFeatured', function (): void {
    $status = FeaturedStatus::NotFeatured;
    $label = $status->label();

    expect($label)->toBe('Not Featured');
});

it('returns the correct label for Featured', function (): void {
    $status = FeaturedStatus::Featured;
    $label = $status->label();

    expect($label)->toBe('Featured');
});

it('returns the correct label for NotFeatured as boolean', function (): void {
    $status = FeaturedStatus::NotFeatured;
    $label = $status->booleanLabel();

    expect($label)->toBe(__('posts.show.No'));
});

it('returns the correct label for Featured as boolean', function (): void {
    $status = FeaturedStatus::Featured;
    $label = $status->booleanLabel();

    expect($label)->toBe(__('posts.show.Yes'));
});

it('returns the correct color for NotFeatured', function (): void {
    $status = FeaturedStatus::NotFeatured;
    $color = $status->color();

    expect($color)->toBe('bg-blue-500');
});

it('returns the correct color for Featured', function (): void {
    $status = FeaturedStatus::Featured;
    $color = $status->color();

    expect($color)->toBe('bg-green-500');
});

it('returns the correct change button label for NotFeatured', function (): void {
    $status = FeaturedStatus::NotFeatured;
    $btnLabel = $status->changeBtnLabel();

    expect($btnLabel)->toBe('Feature');
});

it('returns the correct change button label for Featured', function (): void {
    $status = FeaturedStatus::Featured;
    $btnLabel = $status->changeBtnLabel();

    expect($btnLabel)->toBe('Unfeature');
});

it('returns the correct change button color for NotFeatured', function (): void {
    $status = FeaturedStatus::NotFeatured;
    $btnColor = $status->changeBtnColor();

    expect($btnColor)->toBe('bg-yellow-500 hover:bg-yellow-600');
});

it('returns the correct change button color for Featured', function (): void {
    $status = FeaturedStatus::Featured;
    $btnColor = $status->changeBtnColor();

    expect($btnColor)->toBe('bg-gray-500 hover:bg-gray-600');
});

it('returns the correct button color', function (int $value, string $expected): void {
    expect(FeaturedStatus::tryFrom($value)->buttonColor())->toBe($expected);
})
    ->with([
        FeaturedStatus::Featured->name => [
            'value' => FeaturedStatus::Featured->value,
            'expected' => 'zinc',
        ],
        FeaturedStatus::NotFeatured->name => [
            'value' => FeaturedStatus::NotFeatured->value,
            'expected' => 'yellow',
        ],
    ]);
