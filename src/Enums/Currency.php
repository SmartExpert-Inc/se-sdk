<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class Currency extends Enum
{
    const UAH = 0;
    const USD = 1;
    const RUB = 2;

    public static function getSymbol($value): string
    {
        switch ($value) {
            case self::UAH:
                return '₴';
            case self::USD:
                return '$';
            case self::RUB:
                return '₽';
            default:
                return '';
        }
    }
}
