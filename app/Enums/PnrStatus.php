<?php

namespace App\Enums;

enum PnrStatus: int
{
    case Created    = 1;
    case OnSale     = 2;
    case CancelSale = 3;
    case SoldOut    = 4;
    case Available  = 5;

    public function label(): string
    {
        return match ($this) {
            self::Created   => 'Created',
            self::OnSale  => 'OnSale',
            self::CancelSale => 'CancelSale',
            self::SoldOut => 'SoldOut',
            self::Available => 'Available',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Created   => 'text-yellow-600',
            self::OnSale  => 'text-blue-600',
            self::CancelSale => 'text-red-600',
            self::SoldOut  => 'text-green-600',
            self::Available => 'text-gray-600',
        };
    }
}
