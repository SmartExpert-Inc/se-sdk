<?php

namespace SE\SDK\Services;

use SE\SDK\Contracts\ServiceInterface;
use Illuminate\Http\Request;

abstract class BaseService implements ServiceInterface
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

    public function __construct()
    {
        $this->api = app(ApiClientService::class);

        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
        ];

        $this->prefix = "/api/v1";
    }

    protected function getSessionKey(): string
    {
        $name = $this::USER_SESSION_KEY_NAME;

        $sessionName = session()->getId();

        return "{$name}{$sessionName}";
    }

    protected function withAuth(): void
    {
        $auth = resolve(AuthService::class);
        $token = $auth->getToken();

        if (! $token) {
            $token = request()->headers->get('authorization');
        }

        if (! $token) {
            $token = $auth->clientAuthHeader();
        }

        $this->headers['Authorization'] = $token;
    }

    protected function withLocale(Request $request): void
    {
        $userService = resolve(UserService::class);

        $request->merge([
            'locale' => optional($userService->authUser($request))->locale ?? config('app.locale'),
        ]);
    }
}