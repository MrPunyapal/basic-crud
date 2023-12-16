<?php

declare(strict_types=1);

namespace App\Traits;

trait ArrayableEnum
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
