<?php

namespace SE\SDK;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use SE\SDK\Logging\CustomLogger;
use SE\SDK\Services\{
    ApiClientService, BotService, ChatService, PostService, S3Service, ServicesRegister, Tags\CategoryService, Tags\TagService,
    UserAttributeService, UserService, AuthService, UserSettingService, SocialService
};
use SE\SDK\Client\HttpClient;
use SE\SDK\Handlers\ExceptionHandler;
use GuzzleHttp\Client;

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

        /* Require helpers */
        foreach (glob(__DIR__ . '/Helpers/*.php') as $file) {
            require_once($file);
        }

        if (config('se_sdk.s3')) {
            $disk = config('se_sdk.s3.cloud');
            if (config('filesystems.cloud')) {
                Config::set('filesystems.cloud', config('se_sdk.s3.cloud'));
            }
            if (config("filesystems.disks")) {
                Config::set("filesystems.disks.{$disk}", config("se_sdk.s3.disks.{$disk}"));
            }
        }

        if (config('se_sdk.channels')) {
            Config::set("logging.channels.api", config("se_sdk.channels.api"));
        }

        $this->app->singleton(ApiClientService::class, function () {
            return new ApiClientService(new Client());
        });

        $this->app->singleton(UserService::class, function () {
            return new AuthService(app(ApiClientService::class));
        });

        $this->app->singleton(UserService::class, function () {
            return new UserService(app(ApiClientService::class));
        });

        $this->app->singleton(UserAttributeService::class, function () {
            return new UserAttributeService(app(ApiClientService::class));
        });

        $this->app->singleton(UserSettingService::class, function () {
            return new UserSettingService(app(ApiClientService::class));
        });

        $this->app->singleton(SocialService::class, function () {
            return new SocialService(app(ApiClientService::class));
        });

        $this->app->singleton(PostService::class, function () {
            return new PostService(app(ApiClientService::class));
        });

        $this->app->singleton(BotService::class, function () {
            return new BotService(app(ApiClientService::class));
        });

        $this->app->singleton(TagService::class, function () {
            return new TagService(app(ApiClientService::class));
        });

        $this->app->singleton(CategoryService::class, function () {
            return new CategoryService(app(ApiClientService::class));
        });

        if (config('filesystems')) {
            $this->app->singleton(S3Service::class, function () {
                return new S3Service;
            });
        }

        $this->app->singleton(ChatService::class, function () {
            return new ChatService(app(ApiClientService::class));
        });

        $this->app->singleton(CustomLogger::class, function () {
            $logger = new CustomLogger;
            return $logger(config('logging.channels.api'));
        });

        $this->app->singleton(ExceptionHandler::class, function () {
            return new ExceptionHandler();
        });

        $this->app->bind(static::$abstract, function () {
            return new ServicesRegister();
        });

        $this->app->bind('requests', function () {
            return new HttpClient();
        });
    }
}
