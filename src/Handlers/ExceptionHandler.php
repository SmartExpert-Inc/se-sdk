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
            $token = config('se_sdk.logger.token');
            $this->client->request('POST', $this->webHookUrl, [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$token}",
                ],
                'form_params' => $this->getFormatedData($exception),
            ]);
        } catch (Exception $e) {
            if (app()->environment() != 'production') {
                dump($e->getMessage());
            }

            logger()->error("{$e->getMessage()}, \n{$e->getFile()} in {$e->getLine()}");
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