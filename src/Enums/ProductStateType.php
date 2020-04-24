<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="ProductStateType",
 *     required={"Draft": 0, "Active": 1, "Deactivated": 2, "Archived": 3},
 *     title="Product State Type",
 *     type="array",
 *     @SWG\Items(
 *         type="integer",
 *         title="ProductStateType ID",
 *         default=0,
 *     ),
 * )
 */
final class ProductStateType extends Enum
{
    const Draft = 0;
    const Active = 1;
    const Deactivated = 2;
    const Archived = 3;

    /**
     * @param mixed $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Draft:
                return trans('Draft');
                break;
            case self::Active:
                return trans('Active');
                break;
            case self::Deactivated:
                return trans('Deactivated');
                break;
            case self::Archived:
                return trans('Archived');
                break;
            default:
                return self::getKey($value);
        }
    }

    public static function isDraft(int $value): bool
    {
        return $value == self::Draft;
    }

    public static function isActive(int $value): bool
    {
        return $value == self::Active;
    }

    public static function isDeactivated(int $value): bool
    {
        return $value == self::Deactivated;
    }

    public static function isArchived(int $value): bool
    {
        return $value == self::Archived;
    }
}
