<?php

use App\Enums\FeaturedStatus;

it('returns the correct label for NOT_FEATURED', function () {
    $status = FeaturedStatus::NOT_FEATURED;
    $label = $status->label();

    expect($label)->toBe('No');
});

it('returns the correct label for FEATURED', function () {
    $status = FeaturedStatus::FEATURED;
    $label = $status->label();

    expect($label)->toBe('Yes');
});

// it('returns the correct bg_color for NOT_FEATURED', function () {
//     $status = FeaturedStatus::NOT_FEATURED;
//     $bgColor = $status->bg_color();

//     expect($bgColor)->toBe('bg-info');
// });

// it('returns the correct bg_color for FEATURED', function () {
//     $status = FeaturedStatus::FEATURED;
//     $bgColor = $status->bg_color();

//     expect($bgColor)->toBe('bg-success');
// });
