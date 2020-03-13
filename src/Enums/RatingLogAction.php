<?php

namespace SE\SDK\Enums;

final class RatingLogAction
{
    const CreateHelpPost = 0;
    const DeleteHelpPost = 1;
    const PutThanks = 2;
    const DeleteThanks = 3;
    const GetThanks = 4;
    const DeleteGettingThanks = 5;
    const RepostHelpPost = 6;
    const FirstProductFinished = 7;
    const SecondProductFinished = 8;
    const ThirdProductFinished = 9;
    const AvatarLoaded = 10;
    const SelectedTags = 11;
    const FilledOutProfile = 12;
    const ActiveWeek = 13;
    const ActiveMonth = 14;
    const TwoMonthsActive = 15;

    public static function getAmount($value): int
    {
        switch ($value) {
            case self::CreateHelpPost
                || self::PutThanks:
                return 25;
            case self::DeleteHelpPost
                || self::DeleteThanks:
                return -25;
            case self::GetThanks:
                return 75;
            case self::DeleteGettingThanks:
                return -75;
            case self::RepostHelpPost
                || self::AvatarLoaded
                || self::SelectedTags
                || self::ActiveWeek:
                return 100;
            case self::FilledOutProfile:
                return 200;
            case self::FirstProductFinished
                || self::ActiveMonth:
                return 500;
            case self::SecondProductFinished
                || self::TwoMonthsActive:
                return 1000;
            case self::ThirdProductFinished:
                return 2000;
            default:
                return 0;
        }
    }

    public static function getMaxRepeatingPerDay($value): ?int
    {
        switch ($value) {
            case self::CreateHelpPost
                || self::PutThanks
                || self::GetThanks
                || self::DeleteGettingThanks
                || self::DeleteThanks
                || self::DeleteHelpPost:
                return 3;
            case self::RepostHelpPost:
                return 1;
            default:
                return null;
        }
    }

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::CreateHelpPost:
                return 'Create help post';
            case self::DeleteHelpPost:
                return 'Delete help post';
            case self::PutThanks:
                return 'Put thanks under your help post';
            case self::DeleteThanks:
                return 'Delete thanks under your help post';
            case self::GetThanks:
                return 'Get thanks under your answer on help post';
            case self::DeleteGettingThanks:
                return 'Delete thanks under your answer on help post';
            case self::RepostHelpPost:
                return 'Repost help post';
            case self::FirstProductFinished:
                return 'First product finished';
            case self::SecondProductFinished:
                return 'Second product finished';
            case self::ThirdProductFinished:
                return 'Third product finished';
            case self::AvatarLoaded:
                return 'Avatar loaded';
            case self::SelectedTags:
                return 'Selected tags';
            case self::FilledOutProfile:
                return 'Filled out a full profile';
            case self::ActiveWeek:
                return 'The user takes an active action every day for a week';
            case self::ActiveMonth:
                return 'The user takes an active action every day for a month';
            case self::TwoMonthsActive:
                return 'The user takes an active action every day for a two months';
            default:
                return '';
        }
    }
}
