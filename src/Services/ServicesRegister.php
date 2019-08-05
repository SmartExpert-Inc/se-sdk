<?php

namespace SE\SDK\Services;

use Illuminate\Contracts\Foundation\Application;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use SE\SDK\Services\Posts\PostCategoryService;
use SE\SDK\Services\Posts\PostService;
use SE\SDK\Services\Posts\PostTagService;
use SE\SDK\Services\Posts\CategoryService;

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

    /** @var PostTagService $postTags */
    public $postTags;

    /** @var PostCategoryService $postCategories */
    public $postCategories;

    /** @var BotService $bots */
    public $bot;

    /** @var BotChatService $botChats */
    public $botChats;

    /** @var CategoryService $category */
    public $category;

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
        $this->postTags = $app->make(PostTagService::class);
        $this->postCategories = $app->make(PostCategoryService::class);

        $this->bot = $app->make(BotService::class);
        $this->botChats = $app->make(BotChatService::class);

        $this->category = $app->make(CategoryService::class);
    }
}