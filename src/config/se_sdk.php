<?php

return [
    'auth' => [
        'host' => env('AUTH_SERVICE_HOST', null),
        'socialRoute' => env('AUTH_SERVICE_HOST', null) . '/social/',
        'forgotPasswordRoute' => env('AUTH_SERVICE_HOST', null) . '/api/v1/password/reset',
        'client_credentials' => [
            'client_id' => env('AUTH_CLIENT_ID', null),
            'client_secret' => env('AUTH_CLIENT_SECRET', null),
        ],
        'trial_access_days_count' => env('TRIAL_ACCESS_DAYS_COUNT', 30),
        'system_api_key' => env('SYSTEM_API_KEY', null),
    ],

    'posts' => [
        'host' => env('POSTS_SERVICE_HOST', null),
    ],

    'tags' => [
        'host' => env('TAGS_SERVICE_HOST', null),
    ],

    'bots' => [
        'host' => env('BOTS_SERVICE_HOST', null),
        'telegram' => [
            'name' => env('TELEGRAM_BOT_USERNAME', 'Telegram Bot'),
            'link' => env('TELEGRAM_BOT_LINK', null),
            'callback_token' => env('BOT_CALLBACK_TOKEN', null),
            'enable' => env('TELEGRAM_ENABLE_CHAT', true),
            'token' => env('TELEGRAM_BOT_TOKEN', null),
        ],
        'viber' => [
            'name' => env('VIBER_BOT_USERNAME', 'Viber Bot'),
            'link' => env('VIBER_BOT_LINK', null),
            'callback_token' => env('BOT_CALLBACK_TOKEN', null)
        ],
        'fb' => [
            'name' => env('FB_BOT_USERNAME', 'Facebook Bot'),
            'link' => env('FB_BOT_LINK', null),
            'callback_token' => env('BOT_CALLBACK_TOKEN', null)
        ]
    ],

    'channels' => [
        'api' => [
            'driver' => 'custom',
            'via'    => SE\SDK\Logging\CustomLogger::class,
            'url'    => env('LOGS_SERVICE_HOST'),
            'level'  => 'debug',
        ],
    ],

    'logger' => [
        'token' => env('LOGGER_AUTH_TOKEN')
    ],

    'landings' => [
        'host' => env('LANDINGS_SERVICE_HOST', null),
    ],

    'comments' => [
        'host' => env('COMMENTS_SERVICE_HOST', null),
    ],

    'products' => [
        'host' => env('PRODUCTS_SERVICE_HOST', null),
        'author_training_product' => env('AUTHOR_TRAINING_PRODUCT', null),
        'template_product' => env('TEMPLATE_PRODUCT', null),
        'student_training_product' => env('STUDENT_TRAINING_PRODUCT', null),
    ],

    'todo' => [
        'host' => env('TODO_SERVICE_HOST', null),
    ],

    'platform' => [
        'host' => env('PLATFORM_HOST', null),
    ],

    'community' => [
        'host' => env('COMMUNITY_SERVICE_HOST', null),
    ],

    'billing' => [
        'host' => env('BILLING_SERVICE_HOST', null),
    ],

    'artisan' => [
        'user_email' => env('ARTISAN_USER_EMAIL', 'artisan@app.com'),
        'user_password' => env('ARTISAN_USER_PASSWORD', '12345678'),
    ],

    /**
     *  Use this value for all pagination places
     */
    'default_per_page' => env('DEFAULT_PER_PAGE', 20),
];