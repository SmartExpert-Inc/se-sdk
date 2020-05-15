<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class PostType extends Enum
{
    const Default = 1;
    const Help = 2;

    public static function isHelp(int $value)
    {
        return $value == self::Help;
    }
}
