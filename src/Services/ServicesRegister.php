<?php

namespace SE\SDK\Services;

use Illuminate\Contracts\Foundation\Application;
use SE\SDK\Logging\CustomLogger;
use SE\SDK\Handlers\ExceptionHandler;
use SE\SDK\Services\Todo\{
    PriorityService,
    StagesService,
    TargetsService
};
use SE\SDK\Services\Tags\CategoryService;
use SE\SDK\Services\Tags\TagService;

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

    /** @var PostService $post */
    public $post;

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

    /** @var SE\SDK\Logging\CustomLogger $logger */
    public $logger;

    /** @var CategoryService $category */
    public $category;

    /**
     * ServicesRegister constructor.
     * @param Application $app
     */
    public function __construct()
    {
        $this->auth = app()->make(AuthService::class);

        $this->user = app()->make(UserService::class);
        $this->userAttributes = app()->make(UserAttributeService::class);
        $this->userSettings = app()->make(UserSettingService::class);
        $this->social = app()->make(SocialService::class);

        $this->post = app()->make(PostService::class);

        $this->bot = app()->make(BotService::class);
        $this->chat = app()->make(ChatService::class);

        $this->tag = app()->make(TagService::class);
        $this->category = app()->make(CategoryService::class);

        $this->todoPriority = app()->make(PriorityService::class);
        $this->todoStages = app()->make(StagesService::class);
        $this->todoTargets = app()->make(TargetsService::class);

        if (config('filesystems')) {
            $this->s3 = app()->make(S3Service::class);
        }

        $this->logger = app()->make(CustomLogger::class);
        $this->exception = app()->make(ExceptionHandler::class);
    }
}
