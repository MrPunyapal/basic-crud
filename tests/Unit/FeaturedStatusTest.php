<?php

use App\Enums\FeaturedStatus;

uses(Tests\TestCase::class);

it('returns the correct label for NOT_FEATURED', function () {
    $status = FeaturedStatus::NOT_FEATURED;
    $label = $status->label();

    expect($label)->toBe('Not Featured');
});

it('returns the correct label for FEATURED', function () {
    $status = FeaturedStatus::FEATURED;
    $label = $status->label();

    expect($label)->toBe('Featured');
});

it('returns the correct color for NOT_FEATURED', function () {
    $status = FeaturedStatus::NOT_FEATURED;
    $color = $status->color();

    expect($color)->toBe('bg-info');
});

it('returns the correct color for FEATURED', function () {
    $status = FeaturedStatus::FEATURED;
    $color = $status->color();

    expect($color)->toBe('bg-success');
});

it('returns the correct change button label for NOT_FEATURED', function () {
    $status = FeaturedStatus::NOT_FEATURED;
    $btnLabel = $status->changeBtnLabel();

    expect($btnLabel)->toBe('Feature');
});

it('returns the correct change button label for FEATURED', function () {
    $status = FeaturedStatus::FEATURED;
    $btnLabel = $status->changeBtnLabel();

    expect($btnLabel)->toBe('Unfeature');
});

it('returns the correct change button color for NOT_FEATURED', function () {
    $status = FeaturedStatus::NOT_FEATURED;
    $btnColor = $status->changeBtnColor();

    expect($btnColor)->toBe('btn-warning');
});

it('returns the correct change button color for FEATURED', function () {
    $status = FeaturedStatus::FEATURED;
    $btnColor = $status->changeBtnColor();

    expect($btnColor)->toBe('btn-secondary');
});
