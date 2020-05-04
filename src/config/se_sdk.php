<?php

return [
    'auth' => [
        'host' => env('AUTH_SERVICE_HOST', null),
        'socialRoute' => env('AUTH_SERVICE_HOST', null) . '/social/',
        'forgotPasswordRoute' => env('AUTH_SERVICE_HOST', null) . '/api/v1/password/reset',
        'client_credentials' => [
            'client_id' => env('AUTH_CLIENT_ID', null),
            'client_secret' => env('AUTH_CLIENT_SECRET', null),
        ]
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
        'default' => env('FILESYSTEM_CLOUD', 'do_spaces'),
        'cloud' => env('FILESYSTEM_CLOUD', 'do_spaces'),
        'disks' => [
            'do_spaces' => [
                'driver' => 's3',
                'key' => env('DO_SPACES_KEY'),
                'secret' => env('DO_SPACES_SECRET'),
                'region' => env('DO_SPACES_REGION'), // can be anything
                'bucket' => env('DO_SPACES_BUCKET'),// your space name
                'endpoint' => env('DO_SPACES_ENDPOINT') // spaces endpoint (currently : `https://nyc3.digitaloceanspaces.com`)
            ],
//            'minio' => [
//                'driver' => 's3',
//                'endpoint' => env('MINIO_ENDPOINT', 'http://127.0.0.1:9005'),
//                'use_path_style_endpoint' => true,
//                'key' => env('AWS_KEY'),
//                'secret' => env('AWS_SECRET'),
//                'region' => env('AWS_REGION', 'eu-central-1'),
//                'bucket' => env('AWS_BUCKET'),
//            ],
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
    ],

    'landings' => [
        'host' => env('LANDINGS_SERVICE_HOST', null),
    ],

    'comments' => [
        'host' => env('COMMENTS_SERVICE_HOST', null),
    ],

    'products' => [
        'host' => env('PRODUCTS_SERVICE_HOST', null),
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

    'artisan' => [
        'user_email' => env('ARTISAN_USER_EMAIL', 'artisan@app.com'),
        'user_password' => env('ARTISAN_USER_PASSWORD', '12345678'),
    ],
];