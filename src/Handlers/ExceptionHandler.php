<?php

namespace SE\SDK\Handlers;

use Exception;
use GuzzleHttp\Client;

class ExceptionHandler
{
    /** @var GuzzleHttp\Client $client */
    private $client;

    /** @var string webHookUrl */
    private $webHookUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->webHookUrl = config('se_sdk.channels.api.url');
    }

    public function captureException(Exception $exception)
    {
        $this->client->request('POST', $this->webHookUrl, [
            'json' => $this->getFormatedData($exception),
        ]);
    }

    private function getFormatedData(Exception $exception): array
    {
        return [
            "message" => $exception->getMessage() ?? null,
            "code" => $exception->getCode() ?? null,
            "file" => $exception->getFile() ?? null,
            "line" => $exception->getLine() ?? null,
            "trace" => $exception->getTraceAsString() ?? null,
        ];
    }
}