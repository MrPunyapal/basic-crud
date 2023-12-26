<?php

declare(strict_types=1);

namespace App\Enums;

enum FeaturedStatus: int
{
    case NOT_FEATURED = 0;
    case FEATURED = 1;

    public function label(): string
    {
        return match ($this) {
            self::NOT_FEATURED => __('posts.show.Not Featured'),
            self::FEATURED => __('posts.show.Featured'),
        };
    }

    public function booleanLabel(): string
    {
        return match ($this) {
            self::NOT_FEATURED => __('posts.show.No'),
            self::FEATURED => __('posts.show.Yes'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NOT_FEATURED => 'bg-blue-500',
            self::FEATURED => 'bg-green-500',
        };
    }

    public function changeBtnLabel(): string
    {
        return match ($this) {
            self::NOT_FEATURED => __('posts.form.Feature'),
            self::FEATURED => __('posts.form.Unfeature'),
        };
    }

    public function changeBtnColor(): string
    {
        return match ($this) {
            self::NOT_FEATURED => 'bg-yellow-500 hover:bg-yellow-600',
            self::FEATURED => 'bg-gray-500 hover:bg-gray-600',
        };
    }
}
