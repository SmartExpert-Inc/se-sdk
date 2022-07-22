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
    const UserEmailChangedByAdmin = 'App\Notifications\UserEmailChangedByAdmin';
    const UserPasswordChanged = 'App\Notifications\UserPasswordChanged';
    const SuccessfulImport = 'App\Notifications\SuccessfulImport';
    const FailedImport = 'App\Notifications\FailedImport';
    const SuccessfulExport = 'App\Notifications\SuccessfulExport';
    const LessonNotPassedForTeacher = 'App\Notifications\LessonNotPassedForTeacher';
    const UserGiftRequest = 'App\Notifications\UserGiftRequest';
    const BirthdayNotification = 'App\Notifications\BirthdayNotification';
    const UserGiftRequestAccepted = 'App\Notifications\UserGiftRequestAccepted';
    const UserGiftRequestDeclined = 'App\Notifications\UserGiftRequestDeclined';
    const NotificationAfterStart = 'App\Notifications\NotificationAfterStart';
    const NotificationAfterStartForEvaluated = 'App\Notifications\NotificationAfterStartForEvaluated';
    const NotificationBeforeStart = 'App\Notifications\NotificationBeforeStart';
    const EventReminder = 'App\Notifications\EventReminder';
    const EventReminderDaily = 'App\Notifications\EventReminderDaily';
    const AssessmentCompetencesReportNotification = 'App\Notifications\AssessmentCompetencesReportNotification';
    const AuthorNoProductOneDay = 'App\Notifications\AuthorNoProductOneDay';
    const AuthorNoProductFiveDay = 'App\Notifications\AuthorNoProductFiveDay';
    const AuthorNoProductSevenDay = 'App\Notifications\AuthorNoProductSevenDay';
    const UserFillProfile = 'App\Notifications\UserFillProfile';
    const ProductPerMonthReport = 'App\Notifications\ProductPerMonthReport';
    const AdminFillGamification = 'App\Notifications\AdminFillGamification';
    const UserCreatedEvent = 'App\Notifications\UserCreatedEvent';
    const AuthorFillGamification = 'App\Notifications\AuthorFillGamification';

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