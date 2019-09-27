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
        if (request()->headers->has('Authorization')) {
            $this->headers['Authorization'] = request()->headers->get('Authorization');
        }

        $token = resolve('se_sdk')->auth->getToken();

        if ($token) {
            $this->headers['Authorization'] = $token;
        }
    }
}