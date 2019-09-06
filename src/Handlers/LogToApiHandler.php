<?php

namespace SE\SDK\Handlers;

use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Log;

class LogToApiHandler extends AbstractProcessingHandler
{
    private $webHookUrl;
    private $client;

    public function __construct($webHookUrl, $level = Logger::DEBUG, $bubble = true, $client = null)
    {
        parent::__construct($level, $bubble);

        $this->webHookUrl = $webHookUrl;
        $this->client = ($client) ?: new Client([
            'exceptions' => false,
        ]);
    }

    public function write(array $record): void
    {
        $this->client->request('POST', $this->webHookUrl, [
            'json' => [
                "message" => $record["message"],
                "code" => $record["context"]["code"] ?? null,
                "file" => $record["context"]["file"] ?? null,
                "line" => $record["context"]["line"] ?? null,
                "trace" => $record["context"]["trace"] ?? null,
            ],
        ]);
    }
}