<?php

namespace SE\SDK;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use SE\SDK\Logging\CustomLogger;
use SE\SDK\Services\{
    ApiClientService,
    Auth\GroupService as AuthGroupService,
    Billing\CredentialService,
    Billing\PaymentService,
    BotService,
    CarrotQuestService,
    ChatService,
    Comments\CommentService,
    Comments\LikeService,
    Comments\RepostService,
    Comments\ViewService,
    Community\GroupService,
    LandingService,
    Posts\PostService,
    Posts\StatisticService,
    Products\BannerService,
    Products\CompetenceService,
    Products\GamificationService,
    Products\LessonService,
    Products\LessonableService,
    Products\LibraryService,
    Products\LiveStreamService,
    Products\ModuleService,
    Products\PracticeService,
    Products\ProductService,
    Products\QuestionService,
    Products\ReviewService,
    Products\ScormPackageService,
    Products\StatisticService as ProductStatisticService,
    Products\StudyService,
    Products\TariffService,
    Products\TeacherLinkService,
    Products\TeacherService,
    Products\TestService,
    Products\TextService,
    Products\UserLinkService,
    Products\VideoService,
    Products\GradeService,
    Products\PrizeService,
    Products\RatingService,
    Products\HelpOtherService,
    Products\PresentationService,
    SmartExpertSDK,
    SubdomainService,
    Todo\PriorityService,
    Todo\StagesService,
    Todo\TargetsService,
    UserAttributeService,
    UserService,
    AuthService,
    UserSettingService,
    SocialService,
    Tags\CategoryService,
    Tags\TagService,
    NotificationService,
    GlobalRatingService,
    Community\PostService as CommunityPostService,
    Community\FriendService
};
use SE\SDK\Client\HttpClient;
use SE\SDK\Handlers\ExceptionHandler;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Type to bind tracking as in the Service Container.
     *
     * @var string
     */
    public static $abstract = 'se_sdk';

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/se_sdk.php' => config_path('se_sdk.php'),
            __DIR__.'/config/carrot_quest.php' => config_path('carrot_quest.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/se_sdk.php', 'se_sdk'
        );
        $this->mergeConfigFrom(
            __DIR__.'/config/carrot_quest.php', 'carrot_quest'
        );

        /* Require helpers */
        foreach (glob(__DIR__ . '/Helpers/*.php') as $file) {
            require_once($file);
        }

        if (config('se_sdk.channels')) {
            Config::set("logging.channels.api", config("se_sdk.channels.api"));
        }

        $this->app->singleton(ApiClientService::class, function () {
            return new ApiClientService();
        });

        $this->app->singleton(AuthService::class, function () {
            return new AuthService();
        });

        $this->app->singleton(UserService::class, function () {
            return new UserService();
        });

        $this->app->singleton(UserAttributeService::class, function () {
            return new UserAttributeService();
        });

        $this->app->singleton(UserSettingService::class, function () {
            return new UserSettingService();
        });

        $this->app->singleton(SocialService::class, function () {
            return new SocialService();
        });

        $this->app->singleton(PostService::class, function () {
            return new PostService();
        });

        $this->app->singleton(StatisticService::class, function () {
            return new StatisticService();
        });

        $this->app->singleton(BotService::class, function () {
            return new BotService();
        });

        $this->app->singleton(PriorityService::class, function () {
            return new PriorityService();
        });

        $this->app->singleton(TargetsService::class, function () {
            return new TargetsService();
        });

        $this->app->singleton(StagesService::class, function () {
            return new StagesService();
        });

        $this->app->singleton(TagService::class, function () {
            return new TagService();
        });

        $this->app->singleton(CategoryService::class, function () {
            return new CategoryService();
        });

        $this->app->singleton(LandingService::class, function () {
            return new LandingService();
        });

        $this->app->singleton(ChatService::class, function () {
            return new ChatService();
        });

        /* Bind remote logger */
        $this->app->singleton(CustomLogger::class, function () {
            $logger = new CustomLogger;

            return $logger(config('app.name'), config('logging.channels.api'));
        });

        $this->app->singleton(ExceptionHandler::class, function () {
            return new ExceptionHandler();
        });

        $this->app->singleton(CommentService::class, function () {
            return new CommentService();
        });

        $this->app->singleton(ViewService::class, function () {
            return new ViewService();
        });

        $this->app->singleton(LikeService::class, function () {
            return new LikeService();
        });

        $this->app->singleton(RepostService::class, function () {
            return new RepostService();
        });

        /* Bind requests helper */
        $this->app->bind('requests', function () {
            return new HttpClient();
        });

        /* Bind services registrator */
        $this->app->singleton(static::$abstract, function () {
            return new SmartExpertSDK();
        });

        $this->app->singleton(ProductService::class, function () {
            return new ProductService();
        });

        $this->app->singleton(ModuleService::class, function () {
            return new ModuleService();
        });

        $this->app->singleton(LessonService::class, function () {
            return new LessonService();
        });

        $this->app->singleton(CompetenceService::class, function () {
            return new CompetenceService();
        });

        $this->app->singleton(LessonableService::class, function () {
            return new LessonableService();
        });

        $this->app->singleton(PracticeService::class, function () {
            return new PracticeService();
        });

        $this->app->singleton(QuestionService::class, function () {
            return new QuestionService();
        });

        $this->app->singleton(ReviewService::class, function () {
            return new ReviewService();
        });

        $this->app->singleton(TestService::class, function () {
            return new TestService();
        });

        $this->app->singleton(TextService::class, function () {
            return new TextService();
        });

        $this->app->singleton(VideoService::class, function () {
            return new VideoService();
        });

        $this->app->singleton(LibraryService::class, function () {
            return new LibraryService();
        });

        $this->app->singleton(ScormPackageService::class, function () {
            return new ScormPackageService();
        });

        $this->app->singleton(UserLinkService::class, function () {
            return new UserLinkService();
        });

        $this->app->singleton(TeacherLinkService::class, function () {
            return new TeacherLinkService();
        });

        $this->app->singleton(StudyService::class, function () {
            return new StudyService();
        });

        $this->app->singleton(TeacherService::class, function () {
            return new TeacherService();
        });

        $this->app->singleton(GradeService::class, function () {
            return new GradeService();
        });

        $this->app->singleton(NotificationService::class, function () {
            return new NotificationService();
        });

        $this->app->singleton(GamificationService::class, function () {
            return new GamificationService();
        });

        $this->app->singleton(PrizeService::class, function () {
            return new PrizeService();
        });

        $this->app->singleton(RatingService::class, function () {
            return new RatingService();
        });

        $this->app->singleton(GlobalRatingService::class, function () {
            return new GlobalRatingService();
        });

        $this->app->singleton(HelpOtherService::class, function () {
            return new HelpOtherService();
        });

        $this->app->singleton(PresentationService::class, function () {
            return new PresentationService();
        });

        $this->app->singleton(LiveStreamService::class, function () {
            return new LiveStreamService();
        });

        $this->app->singleton(CommunityPostService::class, function () {
            return new CommunityPostService();
        });

        $this->app->singleton(GroupService::class, function () {
            return new GroupService();
        });

        $this->app->singleton(FriendService::class, function () {
            return new FriendService();
        });

        $this->app->singleton(TariffService::class, function () {
            return new TariffService();
        });

        $this->app->singleton(CredentialService::class, function () {
            return new CredentialService();
        });

        $this->app->singleton(PaymentService::class, function () {
            return new PaymentService();
        });

        $this->app->singleton(ProductStatisticService::class, function () {
            return new ProductStatisticService();
        });

        $this->app->singleton(CarrotQuestService::class, function () {
            return new CarrotQuestService();
        });

        $this->app->singleton(AuthGroupService::class, function () {
            return new AuthGroupService();
        });

        $this->app->singleton(BannerService::class, function () {
            return new BannerService();
        });

        $this->app->singleton(SubdomainService::class, function () {
            return new SubdomainService();
        });
    }
}
