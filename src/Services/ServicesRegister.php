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
use SE\SDK\Services\Products\{
    LessonService,
    LessonableService,
    LibraryService,
    ModuleService,
    PracticeService,
    ProductService,
    QuestionService,
    ReviewService,
    StudyService,
    TeacherLinkService,
    TestService,
    TextService,
    UserLinkService,
    VideoService
};

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

    /** @var UserLinkService $productUser */
    public $productUser;

    /** @var TeacherLinkService $productTeacher */
    public $productTeacher;

    /** @var LessonableService $lessonable */
    public $lessonable;

    /** @var StudyService $study */
    public $study;

    public function __construct()
    {
        $this->auth = app(AuthService::class);

        $this->user = app(UserService::class);
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

        $this->productUser = app(UserLinkService::class);
        $this->productTeacher = app(TeacherLinkService::class);

        $this->study = app(StudyService::class);
    }
}
