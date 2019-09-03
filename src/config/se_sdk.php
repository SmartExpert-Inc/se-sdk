<?php

return [
    'auth' => [
        'host' => env('AUTH_SERVICE_HOST', null),
        'socialRoute' => env('AUTH_SERVICE_HOST', null) . '/social/',
        'forgotPasswordRoute' => env('AUTH_SERVICE_HOST', null) . '/api/v1/password/reset'
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

    's3' => [
        'default' => env('FILESYSTEM_CLOUD', 'minio'),
        'cloud' => env('FILESYSTEM_CLOUD', 'minio'),
        'disks' => [
            'minio' => [
                'driver' => 's3',
                'endpoint' => env('MINIO_ENDPOINT', 'http://127.0.0.1:9005'),
                'use_path_style_endpoint' => true,
                'key' => env('AWS_KEY'),
                'secret' => env('AWS_SECRET'),
                'region' => env('AWS_REGION'),
                'bucket' => env('AWS_BUCKET'),
            ],
        ],
        'thumb' => [
            'width' => 250,
            'height' => 250,
        ],
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
    ]

];