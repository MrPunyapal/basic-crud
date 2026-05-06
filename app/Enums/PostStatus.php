<?php

declare(strict_types=1);

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('posts.status.Draft'),
            self::Published => __('posts.status.Published'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'bg-yellow-500',
            self::Published => 'bg-green-500',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Draft => 'yellow',
            self::Published => 'green',
        };
    }
}
