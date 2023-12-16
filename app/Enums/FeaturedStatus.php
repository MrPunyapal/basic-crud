<?php

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

    public function color(): string
    {
        return match ($this) {
            self::NOT_FEATURED => 'bg-info',
            self::FEATURED => 'bg-success',
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
            self::NOT_FEATURED => 'btn-warning',
            self::FEATURED => 'btn-secondary',
        };
    }
}
