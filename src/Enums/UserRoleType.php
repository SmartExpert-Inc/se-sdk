<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class UserRoleType extends Enum implements LocalizedEnum
{
    const Admin = "Admin";
    const User = "User";
//    const SuperAuthor = "SuperAuthor"; //это была роль для авторов на пять сфер, что б публиковали без редактуры
    const Author = "Author"; // это роль авторов для создания продуктов
//    const DemoAuthor = "DemoAuthor"; // это роль для автора на создание продуктов с ограниченными возможностями
    const Trial = "Trial"; // это роль для автора на создание продуктов с ограниченным временем
    const Manager = "Manager";
    const Student = "Student";

    public static function isAdmin(string $value): bool
    {
        return $value == self::Admin;
    }

    public static function isUser(string $value): bool
    {
        return $value == self::User;
    }

    public static function isAuthor(string $value): bool
    {
        return $value == self::Author;
    }

    public static function isTrial(string $value): bool
    {
        return $value == self::Trial;
    }

    public static function isManager(string $value): bool
    {
        return $value == self::Manager;
    }

    public static function getSettings(string $value): ?array
    {
        switch ($value) {
            case self::Trial:
                return [
                    'access_days_count' => config('se_sdk.auth.trial_access_days_count'),
                ];
                break;
            default:
                return null;
        }
    }
}
