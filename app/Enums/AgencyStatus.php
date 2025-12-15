<?php

namespace App\Enums;

enum AgencyStatus: int
{
    case Pending   = 0;
    case Approved  = 1;
    case Suspended = 2;

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
