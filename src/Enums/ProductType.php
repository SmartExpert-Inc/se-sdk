<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="ProductType",
 *     required={"Course": 0, "Marathon": 1},
 *     title="Product Type",
 *     type="array",
 *     @SWG\Items(
 *         type="integer",
 *         title="ProductType ID",
 *         default=0,
 *     ),
 * )
 */
final class ProductType extends Enum implements LocalizedEnum
{
    const Course = 0;
    const Marathon = 1;

    public static function isCourse(int $value): bool
    {
        return $value == self::Course;
    }

    public static function isMarathon(int $value): bool
    {
        return $value == self::Marathon;
    }
}
