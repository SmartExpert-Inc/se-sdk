<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class RatingLogAction extends Enum
{
    // global rating action
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

    // product rating action
    const PracticeDone = 16;
    const LessonReviewed = 17;
    const TestDone = 18;
    const LessonCommented = 19;
    const FiveLessonDone = 20;
    const TenLessonDone = 20;
    const SaveAllLives = 21;

    // lives count * points
    const SaveSomeLives = 22;
    const LessonDone = 23;

    public static function getAmount(int $value): int
    {
        switch ($value) {
            case self::CreateHelpPost:
            case self::PutThanks:
                return 25;
            case self::DeleteHelpPost:
            case self::DeleteThanks:
                return -25;
            case self::PracticeDone:
            case self::LessonReviewed:
            case self::LessonCommented:
                return 50;
            case self::GetThanks:
                return 75;
            case self::DeleteGettingThanks:
                return -75;
            case self::RepostHelpPost:
            case self::AvatarLoaded:
            case self::SelectedTags:
            case self::ActiveWeek:
                return 100;
            case self::FiveLessonDone:
                return 150;
            case self::FilledOutProfile:
            case self::SaveSomeLives:
                return 200;
            case self::TenLessonDone:
                return 300;
            case self::FirstProductFinished:
            case self::ActiveMonth:
                return 500;
            case self::SecondProductFinished:
            case self::TwoMonthsActive:
            case self::SaveAllLives:
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
            case self::CreateHelpPost:
            case self::PutThanks:
            case self::GetThanks:
            case self::DeleteGettingThanks:
            case self::DeleteThanks:
            case self::DeleteHelpPost:
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
            case self::PracticeDone:
                return 'The user completed a practical task in lesson';
            case self::LessonReviewed:
                return 'The user left review in lesson';
            case self::TestDone:
                return 'The user completed test in lesson';
            case self::LessonDone:
                return 'The user completed lesson';
            case self::LessonCommented:
                return 'The user left comment in lesson';
            case self::FiveLessonDone:
                return 'The user completed five lesson in product';
            case self::TenLessonDone:
                return 'The user completed ten lesson in product';
            case self::SaveAllLives:
                return 'The user save all lives by the end of product';
            case self::SaveSomeLives:
                return 'The user save some lives by the end of product';
            default:
                return '';
        }
    }

    public static function isTestDone($value): bool
    {
        return $value == self::TestDone;
    }

    public static function isLessonDone($value): bool
    {
        return $value == self::LessonDone;
    }

    public static function isSaveSomeLives($value): bool
    {
        return $value == self::SaveSomeLives;
    }
}
