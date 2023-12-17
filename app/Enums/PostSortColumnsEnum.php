<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum PostSortColumnsEnum: string
{
    use ArrayableEnum;

    case TITLE = 'title';
    case IsFeatured = 'is_featured';
}
