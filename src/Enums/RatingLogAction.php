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
    const TenLessonDone = 21;
    const SaveAllLives = 22;

    // lives count * points
    const SaveSomeLives = 23;
    const LessonDone = 24;

    const DeleteOldTestGrade = 25;
    const DeleteOldLessonGrade = 26;

    const CommentedHelpPost = 27;

    public static function getAmount(int $value): int
    {
        switch ($value) {
            case self::CommentedHelpPost:
                return 10;
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
            case self::CommentedHelpPost:
                return 3;
            case self::RepostHelpPost:
                return 1;
            default:
                return null;
        }
    }

    public static function getMaxRepeatingPerRateable($value): int
    {
        switch ($value) {
            case self::CommentedHelpPost:
                return 3;
            default:
                return 1;
        }
    }

    public static function getDescription($value): string
    {
        $key = self::getKey($value);

        return _("ratingLogs.{$key}");
    }

    public static function isTestDone($value): bool
    {
        return $value == self::TestDone;
    }

    public static function isLessonDone($value): bool
    {
        return $value == self::LessonDone;
    }

    public static function isLessonOrTestDone($value): bool
    {
        return $value == self::LessonDone
            || $value == self::TestDone;
    }

    public static function isDeleteOldTestGrade($value): bool
    {
        return $value == self::DeleteOldTestGrade;
    }

    public static function isDeleteOldLessonGrade($value): bool
    {
        return $value == self::DeleteOldLessonGrade;
    }

    public static function isSaveSomeLives($value): bool
    {
        return $value == self::SaveSomeLives;
    }

    public static function isCommentedHelpPost($value): bool
    {
        return $value == self::CommentedHelpPost;
    }
}
