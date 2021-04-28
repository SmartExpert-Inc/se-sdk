<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="UserProductStatusType",
 *     required={"NotStart": 0, "Started": 1, "Passed": 2},
 *     title="User Product Status Type",
 *     type="array",
 *     @SWG\Items(
 *         type="integer",
 *         title="UserProductStatusType ID",
 *         default=0,
 *     ),
 * )
 */
final class UserProductStatusType extends Enum implements LocalizedEnum
{
    const NotStart = 0;
    const Started = 1;
    const Passed = 2;

    public static function isNotStart(int $value): bool
    {
        return $value == self::NotStart;
    }

    public static function isStarted(int $value): bool
    {
        return $value == self::Started;
    }

    public static function isPassed(?int $value): bool
    {
        return $value == self::Passed;
    }
}
