<?php

namespace App\Enums\Discount;

enum DiscountType: int
{
    case Percentage = 0;
    case Fixed = 1;

    // Fulfills the interface contract.
    public static function asValuesArray(): array
    {
        return array_column(self::cases(), 'value');
    }

}

DiscountType::asValuesArray();

