<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="UserGroupType",
 *     required={"User": 0, "Teacher": 1, "Moderator": 2},
 *     title="User Group in Product",
 *     type="array",
 *     @SWG\Items(
 *         type="integer",
 *         title="UserGroupType ID",
 *         default=0,
 *     ),
 * )
 */
final class UserGroupType extends Enum implements LocalizedEnum
{
    const User = 0;
    const Teacher = 1;
    const Moderator = 2;
    const Author = 3;
    const Evaluated = 4;
    const Subordinate = 5;
    const Leader = 6;
    const Colleague = 7;

    /**
     * @param mixed $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::User:
                return trans('User');
                break;
            case self::Teacher:
                return trans('Teacher');
                break;
            case self::Moderator:
                return trans('Moderator');
                break;
            case self::Author:
                return trans('Author');
                break;
            default:
                return self::getKey($value);
        }
    }

    public static function isUser(int $value): bool
    {
        return $value == self::User;
    }

    public static function isTeacher(int $value): bool
    {
        return $value == self::Teacher;
    }

    public static function isModerator(int $value): bool
    {
        return $value == self::Moderator;
    }

    public static function isAuthor(int $value): bool
    {
        return $value == self::Author;
    }

    public static function isNotAuthor(int $value): bool
    {
        return self::isUser($value)
            || self::isModerator($value)
            || self::isTeacher($value);
    }

    public static function getGroupKeysForCompetencyAssessment()
    {
        return [
            UserGroupType::getKey(UserGroupType::Evaluated),
            UserGroupType::getKey(UserGroupType::Subordinate),
            UserGroupType::getKey(UserGroupType::Leader),
            UserGroupType::getKey(UserGroupType::Colleague),
        ];
    }
}
