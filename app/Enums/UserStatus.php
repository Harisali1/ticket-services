<?php

namespace App\Enums;

enum UserStatus: int
{
    case Pending   = 1;
    case Approved  = 2;
    case Suspended = 3;

    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Pending',
            self::Approved  => 'Approved',
            self::Suspended => 'Suspended',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending   => 'text-yellow-600',
            self::Approved  => 'text-green-600',
            self::Suspended => 'text-red-600',
        };
    }
}
