<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class NotificationType extends Enum
{
    const LessonOnCheck = 'App\Notifications\LessonOnCheck';
    const LessonOnCheckForTeacher = 'App\Notifications\LessonOnCheckForTeacher';
    const LessonOpened = 'App\Notifications\LessonOpened';
    const LessonPassed = 'App\Notifications\LessonPassed';
    const LessonReturned = 'App\Notifications\LessonReturned';
    const LessonStarted = 'App\Notifications\LessonStarted';
    const UserActivatedInProduct = 'App\Notifications\UserActivatedInProduct';
    const UserBlockedInProduct = 'App\Notifications\UserBlockedInProduct';
    const UserInactive = 'App\Notifications\UserInactive';
    const UserRegistered = 'App\Notifications\UserRegistered';
    const NewHelpPost = 'App\Notifications\NewHelpPost';
    const RatingNotification = 'App\Notifications\RatingNotification';

    public static function isRatingNotification($value): bool
    {
        return $value == self::RatingNotification;
    }
}