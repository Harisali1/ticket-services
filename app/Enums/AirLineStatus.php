<?php

namespace App\Enums;

enum AirLineStatus: int
{
    case Active   = 1;
    case DeActive  = 2;

    public function label(): string
    {
        return match ($this) {
            self::Active   => 'Active',
            self::DeActive  => 'DeActive',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active  => 'text-green-600',
            self::DeActive => 'text-red-600',
        };
    }
}
