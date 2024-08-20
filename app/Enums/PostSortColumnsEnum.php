<?php

declare(strict_types=1);

namespace App\Enums;

enum PostSortColumnsEnum: string
{
    case Title = 'title';
    case IsFeatured = 'is_featured';

    /**
     * @return array<int, string>
     */
    public static function columns(): array
    {
        return array_column(self::cases(), 'value');
    }
}
