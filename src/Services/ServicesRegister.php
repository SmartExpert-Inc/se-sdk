<?php

namespace SE\SDK\Services;

use Illuminate\Contracts\Foundation\Application;
use SE\SDK\Logging\CustomLogger;
use SE\SDK\Handlers\ExceptionHandler;
use SE\SDK\Services\Comments\{
    CommentService, LikeService, RepostService, ViewService
};
use SE\SDK\Services\Posts\{
    PostService, StatisticService
};
use SE\SDK\Services\Todo\{
    PriorityService,
    StagesService,
    TargetsService
};
use SE\SDK\Services\Tags\{
    CategoryService, TagService
};
use SE\SDK\Services\Products\{GamificationService,
    GradeService,
    LessonService,
    LessonableService,
    LibraryService,
    LiveStreamService,
    ModuleService,
    PracticeService,
    PrizeService,
    ProductService,
    QuestionService,
    ReviewService,
    StatisticService as ProductStatisticService,
    StudyService,
    TariffService,
    TeacherLinkService,
    TeacherService,
    TestService,
    TextService,
    UserLinkService,
    VideoService,
    RatingService,
    HelpOtherService,
    PresentationService};
use SE\SDK\Services\Community\{GroupService, PostService as CommunityPostService, FriendService};
use SE\SDK\Services\Billing\{CredentialService, PaymentService};

final class ServicesRegister
{
    /** @var UserService $user */
    public $user;

    /** @var AuthService $auth */
    public $auth;

    /** @var UserAttributeService $userAttributes */
    public $userAttributes;

    /** @var UserSettingService $userSettings */
    public $userSettings;

    /** @var SocialService $social */
    public $social;

    /** @var PostService $post */
    public $post;

    /** @var StatisticService $postStatistic */
    public $postStatistic;

    /** @var BotService $bots */
    public $bot;

    /** @var ChatService $botChats */
    public $chat;

    /** @var TagService $tag */
    public $tag;

    /** @var PriorityService $todoPriority */
    public $todoPriority;

    /** @var StagesService $todoStages */
    public $todoStages;

    /** @var TargetsService $todoTargets */
    public $todoTargets;

    /** @var S3Service $s3 */
    public $s3;

    /** @var CustomLogger $logger */
    public $logger;

    /** @var CategoryService $category */
    public $category;

    /** @var LandingService $landing */
    public $landing;

    /** @var CommentService $comment */
    public $comment;

    /** @var LikeService $like */
    public $like;

    /** @var RepostService $repost */
    public $repost;

    /** @var ViewService $view */
    public $view;

    /** @var ProductService $product */
    public $product;

    /** @var LessonService $lesson */
    public $lesson;

    /** @var ModuleService $module */
    public $module;

    /** @var PracticeService $lessonPractice */
    public $lessonPractice;

    /** @var QuestionService $lessonQuestion */
    public $lessonQuestion;

    /** @var ReviewService $lessonReview */
    public $lessonReview;

    /** @var TestService $lessonTest */
    public $lessonTest;

    /** @var TextService $lessonText */
    public $lessonText;

    /** @var VideoService $lessonVideo */
    public $lessonVideo;

    /** @var LibraryService $lessonLibrary */
    public $lessonLibrary;

    /** @var HelpOtherService $lessonHelpOther */
    public $lessonHelpOther;

    /** @var PresentationService $lessonPresentation */
    public $lessonPresentation;

    /** @var LiveStreamService $lessonLiveStream */
    public $lessonLiveStream;

    /** @var UserLinkService $productUser */
    public $productUser;

    /** @var TeacherLinkService $productTeacher */
    public $productTeacher;

    /** @var LessonableService $lessonable */
    public $lessonable;

    /** @var StudyService $study */
    public $study;

    /** @var TeacherService $teacherCabinet */
    public $teacherCabinet;

    /** @var GradeService $grade */
    public $grade;

    /** @var NotificationService $notification */
    public $notification;

    /** @var GamificationService $gamification */
    public $gamification;

    /** @var PrizeService $prize */
    public $prize;

    /** @var RatingService $productRating */
    public $productRating;

    /** @var GlobalRatingService $globalRating */
    public $globalRating;

    /** @var CommunityPostService $communityPost */
    public $communityPost;

    /** @var GroupService $communityGroup */
    public $communityGroup;

    /** @var FriendService $communityFriend */
    public $communityFriend;

    /** @var CredentialService $credential*/
    public $credential;

    /** @var TariffService $productTariff*/
    public $productTariff;

    /** @var PaymentService $payments*/
    public $payments;

    /** @var ProductStatisticService $productStatistic */
    public $productStatistic;

    /** @var \SE\SDK\Services\Auth\GroupService $group */
    public $group;

    public function __construct()
    {
        $this->auth = app(AuthService::class);

        $this->user = app(UserService::class);
        $this->group = app(Auth\GroupService::class);
        $this->userAttributes = app(UserAttributeService::class);
        $this->userSettings = app(UserSettingService::class);
        $this->social = app(SocialService::class);

        $this->post = app(PostService::class);
        $this->postStatistic = app(StatisticService::class);

        $this->bot = app(BotService::class);
        $this->chat = app(ChatService::class);

        $this->tag = app(TagService::class);
        $this->category = app(CategoryService::class);

        $this->todoPriority = app(PriorityService::class);
        $this->todoStages = app(StagesService::class);
        $this->todoTargets = app(TargetsService::class);

        if (config('filesystems')) {
            $this->s3 = app(S3Service::class);
        }

        $this->logger = app(CustomLogger::class);
        $this->exception = app(ExceptionHandler::class);

        $this->landing = app(LandingService::class);

        $this->comment = app(CommentService::class);
        $this->like = app(LikeService::class);
        $this->repost = app(RepostService::class);
        $this->view = app(ViewService::class);

        $this->product = app(ProductService::class);
        $this->productStatistic = app(ProductStatisticService::class);
        $this->module = app(ModuleService::class);
        $this->lesson = app(LessonService::class);
        $this->lessonable = app(LessonableService::class);
        $this->lessonPractice = app(PracticeService::class);
        $this->lessonQuestion = app(QuestionService::class);
        $this->lessonReview = app(ReviewService::class);
        $this->lessonTest = app(TestService::class);
        $this->lessonText = app(TextService::class);
        $this->lessonVideo = app(VideoService::class);
        $this->lessonLibrary = app(LibraryService::class);
        $this->lessonHelpOther = app(HelpOtherService::class);
        $this->lessonPresentation = app(PresentationService::class);
        $this->lessonLiveStream = app(LiveStreamService::class);

        $this->productUser = app(UserLinkService::class);
        $this->productTeacher = app(TeacherLinkService::class);
        $this->productTariff = app(TariffService::class);

        $this->study = app(StudyService::class);
        $this->teacherCabinet = app(TeacherService::class);
        $this->grade = app(GradeService::class);

        $this->gamification = app(GamificationService::class);
        $this->prize = app(PrizeService::class);
        $this->productRating = app(RatingService::class);

        $this->notification = app(NotificationService::class);
        $this->globalRating = app(GlobalRatingService::class);

        $this->communityPost = app(CommunityPostService::class);
        $this->communityGroup = app(GroupService::class);
        $this->communityFriend = app(FriendService::class);

        //billing
        $this->credential = app(CredentialService::class);
        $this->payments = app(PaymentService::class);

        $this->carrotQuest = app(CarrotQuestService::class);
    }
}
