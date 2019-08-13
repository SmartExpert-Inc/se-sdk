<?php

namespace SE\SDK\Logging;

use Monolog\Logger;
use SE\SDK\Handlers\LogToApiHandler;

class CustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array $config
     *
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        return new Logger(
            env('APP_NAME'),
            [
                new LogToApiHandler(
                    $config['url'],
                    $config['level']
                ),
            ]
        );
    }
}