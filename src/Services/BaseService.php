<?php

namespace SE\SDK\Services;

abstract class BaseService
{
    const USER_SESSION_KEY_NAME = "user:session:";

    /** @var ApiClientService $api */
    protected $api;

    /** @var array $headers */
    protected $headers;

    /** @var string $host */
    protected $host;

    /** @var string $prefix */
    protected $prefix;

    public function __construct(ApiClientService $api)
    {
        $this->api = $api;

        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
        ];

        $this->host = config('se_sdk.auth.host');
        $this->prefix = "/api/v1";
    }

    protected function getSessionKey(): string
    {
        $name = $this::USER_SESSION_KEY_NAME;

        $sessionName = session()->getId();

        return "{$name}{$sessionName}";
    }

    protected function withAut(): void
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();
    }

    protected function badResponse($response, $results=null)
    {
        if (is_callable($results)) {
            if (! $response or ! property_exists($response, "data")) {
                if ($results) {
                    return $results;
                }

                return null;
            }
        }

        if (! $response or property_exists($response, "errors")) {
            if ($results) {
                return $results;
            }

            return [
                'response' => $response,
            ];
        }
    }
}