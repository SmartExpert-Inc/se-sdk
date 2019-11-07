<?php

namespace SE\SDK\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

final class AuthService extends BaseService
{
    const PASSWORD_GRANT_TYPE = 'password';
    const CLIENT_CREDENTIALS_GRANT_TYPE = 'client_credentials';

    public function register(Request $request): ?\stdClass
    {
        $registered = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/register', $request->all())
            ->getObject();

        $cookies = $this->api->getLastCookies();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! $registered or ! property_exists($registered, "data")) {
            return $registered;
        }

        session()->put([
            'secret' => $registered->data->secret,
            'client_id' => $registered->data->client_id,
            'user' => $registered->data->user
        ]);

        return $this->authorise($request, $cookies);
    }

    public function login(Request $request): ?\stdClass
    {
        $auth = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/login', $request->all())
            ->getObject();

        $cookies = $this->api->getLastCookies();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! $auth or ! property_exists($auth, "data")) {
            return $auth;
        }

        if (! session()->has("user")) {
            session()->put([
                'secret' => $auth->data->secret,
                'client_id' => $auth->data->client_id,
                'user' => $auth->data->user
            ]);
        }

        return $this->authorise($request, $cookies);
    }

    public function loginAs(Request $request): ?\stdClass
    {
        $this->withAuth();

        $auth = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/users/login-as', $request->all())
            ->getObject();

        $cookies = $this->api->getLastCookies();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! $auth or ! property_exists($auth, "data")) {
            return $auth;
        }

        if (! session()->has("user")) {
            session()->put([
                'secret' => $auth->data->secret,
                'client_id' => $auth->data->client_id,
                'user' => $auth->data->user
            ]);
        }

        return $this->authorise($request, $cookies);
    }

    public function authorise(Request $request, ?array $cookies = []): ?\stdClass
    {
        $keyName = $this->getSessionKey();
        $accessToken = Redis::get($keyName);

        if ($accessToken) {
            return (object) [
                'response' => (object) [
                    'access_token' => $accessToken
                ]
            ];
        }

        $requestArr =  [
            'grant_type' => self::CLIENT_CREDENTIALS_GRANT_TYPE,
            'client_id' => (string) session()->get('client_id'),
            'client_secret' => session()->get('secret'),
        ];

        if (! $request->has('social')) {
            $requestArr = array_merge($requestArr, [
                'grant_type' => self::PASSWORD_GRANT_TYPE,
                'username' => $request->input('email'),
                'password' => $request->input('password')
            ]);
        }

        $oauth = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->post('/oauth/token', $requestArr)
            ->getObject();

        $cookie = $this->api->getLastCookies();
        $cookies = array_merge($cookies ?? [], $cookie);

        $this->api->dropState();
        $this->api->dropUrls();

//        TODO: Check scalar field in $oauth response
        $results = [
            'response' => json_decode($oauth->scalar),
            'cookies' => $cookies
        ];

        $this->setTokenToSession(json_decode($oauth->scalar));

        return (object) $results;
    }

    public function logout(): ?\stdClass
    {
        $keyName = $this->getSessionKey();
        Redis::del($keyName);
        session()->invalidate();

        $logout = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->post('/api/v1/logout')
            ->getObject();

        return $logout;
    }

    public function credentials(Request $request): ?\stdClass
    {
        $this->headers['Authorization'] = $request->headers->get('authorization');

        $credentials = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/credentials')
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! property_exists($credentials, "data")) {
            return null;
        }

        return $credentials->data;
    }

    private function refreshToken($cookies = []): ?\stdClass
    {
        $refreshToken = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->post('/oauth/token/refresh', [
                'form_params' => [
                    'grant_type' => self::PASSWORD_GRANT_TYPE,
                    'client_id' => session()->get('client_id'),
                    'client_secret' => session()->get('secret'),
                    'refresh_token' => session()->get('refresh_token')
                ]
            ])
            ->getObject();

        $cookie = $this->api->getLastCookies();
        $cookies = array_merge($cookies, $cookie);

        $this->api->dropState();
        $this->api->dropUrls();

        $results = [
            'response' => $refreshToken,
            'cookies' => $cookies
        ];

        $this->setTokenToSession($refreshToken);

        return (object) $results;
    }

    private function setTokenToSession(\stdClass $result): void
    {
        $keyName = $this->getSessionKey();

        Redis::set($keyName, $result->access_token, 'EX', $result->expires_in);

        session()->put([
            "token_type" => $result->token_type,
            "expires_in" => $result->expires_in,
            "access_token" => $result->access_token,
            "refresh_token" => $result->refresh_token ?? null
        ]);
    }

    public function hasToken(): bool
    {
        $keyName = $this->getSessionKey();

        if (Redis::ttl($keyName) == -2) {
            if (! session()->has('access_token')) {
                return false;
            }

            Redis::set($keyName, session()->get('access_token'), 'EX', session()->get('expires_in'));
        }

        if (Redis::ttl($keyName) == -1) {
            $cookies = $this->api->getLastCookies();

            $this->refreshToken($cookies);
        }

        return true;
    }

    public function getToken(): string
    {
        $keyName = $this->getSessionKey();
        $accessToken = Redis::get($keyName);
        $tokenType = session()->get('token_type', 'Bearer');

        return $this->hasToken()
            ? "{$tokenType} {$accessToken}"
            : '';
    }

    public function user(): ?\stdClass
    {
        if (session()->has('user')) {
            return (object) session()->get('user');
        }

        return null;
    }

    public function sendResetLinkEmail(Request $request): ?\stdClass
    {
        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/password/email', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function resetPassword(Request $request): ?\stdClass
    {
        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/password/reset', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function clientCredentials(): ?\stdClass
    {
        $requestArr = [
            'grant_type' => self::CLIENT_CREDENTIALS_GRANT_TYPE,
            'client_id' => config('se_sdk.auth.client_credentials.client_id'),
            'client_secret' => config('se_sdk.auth.client_credentials.client_secret'),
        ];

        $oauth = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->post('/oauth/token', $requestArr)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return (object) $oauth;
    }

    public function clientAuthHeader(): ?string
    {
        $auth = $this->clientCredentials();

        if (! property_exists($auth, "scalar")) {
            return null;
        }

        $auth = json_decode($auth->scalar);

        return "{$auth->token_type} {$auth->access_token}";
    }
}