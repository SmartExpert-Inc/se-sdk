<?php

namespace SE\SDK;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use SE\SDK\Logging\CustomLogger;
use SE\SDK\Services\{
    ApiClientService,
    BotService,
    BotChatService,
    PostService,
    S3Service,
    ServicesRegister,
    TagService,
    UserAttributeService,
    UserService,
    AuthService,
    UserSettingService
};
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

        if (config('se_sdk.s3')) {
            $disk = config('se_sdk.s3.cloud');
            Config::set('filesystems.cloud', config('se_sdk.s3.cloud'));
            Config::set("filesystems.disks.{$disk}", config("se_sdk.s3.disks.{$disk}"));
        }

        if (config('se_sdk.channels')) {
            Config::set("logging.channels.api", config("se_sdk.channels.api"));
        }

        $this->app->singleton(ApiClientService::class, function ($app) {
            return new ApiClientService(new Client());
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new AuthService(resolve(ApiClientService::class));
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(resolve(ApiClientService::class));
        });

        $this->app->singleton(UserAttributeService::class, function ($app) {
            return new UserAttributeService(resolve(ApiClientService::class));
        });

        $this->app->singleton(UserSettingService::class, function ($app) {
            return new UserSettingService(resolve(ApiClientService::class));
        });

        $this->app->singleton(PostService::class, function ($app) {
            return new PostService(resolve(ApiClientService::class));
        });

        $this->app->singleton(BotService::class, function ($app) {
            return new BotService(resolve(ApiClientService::class));
        });

        $this->app->singleton(TagService::class, function () {
            return new TagService(resolve(ApiClientService::class));
        });

        $this->app->singleton(S3Service::class, function () {
            return new S3Service;
        });

        $this->app->singleton(BotChatService::class, function ($app) {
            return new BotChatService(resolve(ApiClientService::class));
        });

        $this->app->singleton(CustomLogger::class, function () {
            $logger = new CustomLogger;
            return $logger(config('logging.channels.api'));
        });

        $this->app->bind(static::$abstract, function ($app) {
            return new ServicesRegister($app);
        });
    }
}
