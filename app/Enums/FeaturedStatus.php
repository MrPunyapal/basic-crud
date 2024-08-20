<?php

declare(strict_types=1);

namespace App\Enums;

enum FeaturedStatus: int
{
    case NotFeatured = 0;
    case Featured = 1;

    public function label(): string
    {
        return match ($this) {
            self::NotFeatured => __('posts.show.Not Featured'),
            self::Featured => __('posts.show.Featured'),
        };
    }

    public function booleanLabel(): string
    {
        return match ($this) {
            self::NotFeatured => __('posts.show.No'),
            self::Featured => __('posts.show.Yes'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NotFeatured => 'bg-blue-500',
            self::Featured => 'bg-green-500',
        };
    }

    public function changeBtnLabel(): string
    {
        return match ($this) {
            self::NotFeatured => __('posts.form.Feature'),
            self::Featured => __('posts.form.Unfeature'),
        };
    }

    public function changeBtnColor(): string
    {
        return match ($this) {
            self::NotFeatured => 'bg-yellow-500 hover:bg-yellow-600',
            self::Featured => 'bg-gray-500 hover:bg-gray-600',
        };
    }

    public function buttonColor(): string
    {
        return match ($this) {
            self::NotFeatured => 'yellow',
            self::Featured => 'zinc',
        };
    }
}
