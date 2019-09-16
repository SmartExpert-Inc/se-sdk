<?php

namespace SE\SDK\Services;

use Illuminate\Contracts\Foundation\Application;
use SE\SDK\Logging\CustomLogger;
use SE\SDK\Handlers\ExceptionHandler;

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

    /** @var S3Service $s3 */
    public $s3;

    /** @var SE\SDK\Logging\CustomLogger $logger */
    public $logger;

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

        $this->post = app()->make(PostService::class);

        $this->bot = app()->make(BotService::class);
        $this->chat = app()->make(ChatService::class);

        $this->tag = app()->make(TagService::class);

        if (config('filesystems')) {
            $this->s3 = app()->make(S3Service::class);
        }

        $this->logger = app()->make(CustomLogger::class);
        $this->exception = app()->make(ExceptionHandler::class);
    }
}
