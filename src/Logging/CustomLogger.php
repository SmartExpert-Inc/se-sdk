<?php

namespace SE\SDK\Logging;

use Monolog\Logger;
use SE\SDK\Handlers\LogToApiHandler;

class CustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  string $name
     * @param  array $config
     *
     * @return \Monolog\Logger
     */
    public function __invoke(string $name, array $config)
    {
        return new Logger(
            $name,
            [
                new LogToApiHandler(
                    $config['url'],
                    $config['level']
                ),
            ]
        );
    }
}