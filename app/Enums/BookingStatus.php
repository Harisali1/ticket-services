<?php

namespace App\Enums;

enum BookingStatus: int
{
    case Created   = 1;
    case Ticketed  = 2;
    case Paid = 3;
    case Abounded = 4;
    case Cancel = 5;

    public function label(): string
    {
        return match ($this) {
            self::Created   => 'Created',
            self::Ticketed  => 'Ticketed',
            self::Paid => 'Paid',
            self::Abounded => 'Abounded',
            self::Cancel => 'Cancel',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Created   => 'text-yellow-600',
            self::Ticketed  => 'text-blue-600',
            self::Paid => 'text-green-600',
            self::Abounded  => 'text-gray-600',
            self::Cancel => 'text-red-600',
        };
    }
}
