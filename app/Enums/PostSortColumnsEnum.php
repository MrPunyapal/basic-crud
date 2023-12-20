<?php

namespace App\Enums;

enum PostSortColumnsEnum: string
{
    case TITLE = 'title';
    case IsFeatured = 'is_featured';

    /**
     * @return  array<int, string>
     */
    public static function columns(): array
    {
        return array_column(self::cases(), 'value');
    }
}
