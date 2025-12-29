<?php

namespace App\Enums;

enum BookingStatus: int
{
    case Ticketed   = 1;
    case Reserved  = 2;
    case Paid = 3;
    case Abounded = 4;
    case Cancel = 5;

    public function label(): string
    {
        return match ($this) {
            self::Ticketed   => 'Ticketed',
            self::Reserved  => 'Reserved',
            self::Paid => 'Paid',
            self::Abounded => 'Abounded',
            self::Cancel => 'Cancel',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Ticketed   => 'text-yellow-600',
            self::Reserved  => 'text-blue-600',
            self::Paid => 'text-green-600',
            self::Abounded  => 'text-gray-600',
            self::Cancel => 'text-red-600',
        };
    }
}
