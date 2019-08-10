<?php

namespace SE\SDK\Services;

use Illuminate\Contracts\Foundation\Application;
use SE\SDK\Services\Posts\PostService;

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

    /** @var BotChatService $botChats */
    public $botChats;

    /** @var TagService $tag */
    public $tag;

    /** @var S3Service $s3 */
    public $s3;

    /**
     * ServicesRegister constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->auth = $app->make(AuthService::class);

        $this->user = $app->make(UserService::class);
        $this->userAttributes = $app->make(UserAttributeService::class);
        $this->userSettings = $app->make(UserSettingService::class);

        $this->post = $app->make(PostService::class);

        $this->bot = $app->make(BotService::class);
        $this->botChats = $app->make(BotChatService::class);

        $this->tag = $app->make(TagService::class);

        $this->s3 = $app->make(S3Service::class);
    }
}