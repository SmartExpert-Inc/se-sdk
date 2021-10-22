<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="ProductType",
 *     required={"Course": 0, "Marathon": 1, "Event": 2, "Game": 3},
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
    const Event = 2;
    const Game = 3;

    public static function isCourse(int $value): bool
    {
        return $value == self::Course;
    }

    public static function isMarathon(int $value): bool
    {
        return $value == self::Marathon;
    }

    public static function isEvent(int $value): bool
    {
        return $value == self::Event;
    }

    public static function isGame(int $value): bool
    {
        return $value == self::Game;
    }
}
