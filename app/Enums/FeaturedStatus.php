<?php

namespace App\Enums;

enum FeaturedStatus: int
{
    case NOT_FEATURED = 0;
    case FEATURED = 1;

    public function label(): string
    {
        return match ($this) {
            self::NOT_FEATURED => 'No',
            self::FEATURED => 'Yes',
        };
    }

    // public function bg_color():string
    // {
    //     return match ($this) {
    //         self::NOT_FEATURED => 'bg-info',
    //         self::FEATURED => 'bg-success',
    //     };
    // }

}
