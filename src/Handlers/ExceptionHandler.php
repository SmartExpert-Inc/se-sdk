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
        try {
            $this->client->request('POST', $this->webHookUrl, [
                'json' => $this->getFormatedData($exception),
            ]);
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    private function getFormatedData(Exception $exception): array
    {
        return [
            "message" => $exception->getMessage() ?? null,
            "code" => $exception->getCode() ?? null,
            "file" => $exception->getFile() ?? null,
            "line" => $exception->getLine() ?? null,
            "trace" => $exception->getTraceAsString() ?? null,
            "env" => app()->environment() ?? null,
            "app_name" => config('app.name') ?? null,
        ];
    }
}