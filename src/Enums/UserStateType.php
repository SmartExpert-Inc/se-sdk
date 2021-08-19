<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="UserStateType",
 *     required={"HasAccess": 0, "Blocked": 1},
 *     title="User State in Product",
 *     type="array",
 *     @SWG\Items(
 *         type="integer",
 *         title="UserStateType ID",
 *         default=0,
 *     ),
 * )
 */
final class UserStateType extends Enum
{
    const HasAccess = 0;
    const Blocked = 1;

    /**
     * @param mixed $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::HasAccess:
                return trans('HasAccess');
                break;
            case self::Blocked:
                return trans('Blocked');
                break;
            default:
                return self::getKey($value);
        }
    }

    public static function hasAccess(int $value): bool
    {
        return $value == self::HasAccess;
    }

    public static function isBlocked(int $value): bool
    {
        return $value == self::Blocked;
    }
}
