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
    }
}
