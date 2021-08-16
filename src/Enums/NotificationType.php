<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class NotificationType extends Enum
{
    const LessonOnCheck = 'App\Notifications\LessonOnCheck';
    const LessonOnCheckForTeacher = 'App\Notifications\LessonOnCheckForTeacher';
    const LessonOpened = 'App\Notifications\LessonOpened';
    const LessonPassed = 'App\Notifications\LessonPassed';
    const LessonPassedForTeacher = 'App\Notifications\LessonPassedForTeacher';
    const LessonReturned = 'App\Notifications\LessonReturned';
    const LessonStarted = 'App\Notifications\LessonStarted';
    const UserActivatedInProduct = 'App\Notifications\UserActivatedInProduct';
    const UserBlockedInProduct = 'App\Notifications\UserBlockedInProduct';
    const UserInactive = 'App\Notifications\UserInactive';
    const UserRegistered = 'App\Notifications\UserRegistered';
    const NewHelpPost = 'App\Notifications\NewHelpPost';
    const RatingNotification = 'App\Notifications\RatingNotification';
    const LiveStreamNotification = 'App\Notifications\LiveStreamNotification';
    const NewPublishedLesson = 'App\Notifications\NewPublishedLesson';
    const ProductPassed = 'App\Notifications\ProductPassed';
    const SkippedTaskNotification = 'App\Notifications\SkippedTaskNotification';
    const SkippedTaskNotificationForStudent = 'App\Notifications\SkippedTaskNotificationForStudent';
    const NewCommentInLessonForTeachers = 'App\Notifications\NewCommentInLessonForTeachers';
    const LessonContentChanged = 'App\Notifications\LessonContentChanged';
    const NewLessonAvailable = 'App\Notifications\NewLessonAvailable';

    public static function isRatingNotification($value): bool
    {
        return $value == self::RatingNotification;
    }

    public static function isLiveStreamNotification($value): bool
    {
        return $value == self::LiveStreamNotification;
    }

    public static function isLessonPassed($value): bool
    {
        return $value == self::LessonPassed;
    }

    public static function isLessonReturned($value): bool
    {
        return $value == self::LessonReturned;
    }
}