<?php

namespace SE\SDK\Services;

use Illuminate\Support\Facades\Redis;

final class AuthService extends BaseService
{
    const PASSWORD_GRANT_TYPE = 'password';
    const CLIENT_CREDENTIALS_GRANT_TYPE = 'client_credentials';

    public function register(array $request): ?array
    {
        $registered = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/register', $request)
            ->getObject();

        $cookies = $this->api->getLastCookies();

        $this->api->dropState();
        $this->api->dropUrls();

        if (isset($registered->errors)) {
            return [
                'response' => $registered,
                'cookies' => $cookies
            ];
        }

        session()->put([
            'secret' => $registered->data->secret,
            'client_id' => $registered->data->client_id,
            'user' => $registered->data->user
        ]);

        return $this->authorise($request, $cookies);
    }

    public function login(array $request): ?array
    {
        $auth = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/login', $request)
            ->getObject();

        $cookies = $this->api->getLastCookies();

        $this->api->dropState();
        $this->api->dropUrls();

        if (isset($auth->errors)) {
            return [
                'response' => $auth,
                'cookies' => $cookies
            ];
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

    public function loginAs(array $request): ?array
    {
        $auth = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/login-as', $request)
            ->getObject();

        $cookies = $this->api->getLastCookies();

        $this->api->dropState();
        $this->api->dropUrls();

        if (isset($auth->errors)) {
            return [
                'response' => $auth,
                'cookies' => $cookies
            ];
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

    public function authorise(array $request, ?array $cookies = []): ?array
    {
        $key = $this->getSessionKey();
        $user = Redis::get($key);

        if ($user) {
            return [
                'response' => (object) [
                    'access_token' => $user
                ]
            ];
        }

        $requestArr =  [
            'grant_type' => self::CLIENT_CREDENTIALS_GRANT_TYPE,
            'client_id' => (string) session()->get('client_id'),
            'client_secret' => session()->get('secret'),
        ];

        if (! isset($request['social'])) {
            $requestArr = array_merge($requestArr, [
                'grant_type' => self::PASSWORD_GRANT_TYPE,
                'username' => $request['email'],
                'password' => $request['password']
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

        $results = [
            'response' => json_decode($oauth->scalar),
            'cookies' => $cookies
        ];

        if (!isset($oauth->error)) {
            $this->setTokenToSession(json_decode($oauth->scalar));
        }

        return $results;
    }

    public function logout()
    {
        $key = $this->getSessionKey();
        Redis::del($key);
        session()->invalidate();

        $logout = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->post('/api/v1/logout')
            ->getObject();

        return $logout;
    }

    private function refreshToken($cookies = [])
    {
        $refresh_token = $this->api
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
            'response' => $refresh_token,
            'cookies' => $cookies
        ];

        $this->setTokenToSession($refresh_token);

        return $results;
    }

    private function setTokenToSession(\stdClass $result) :bool
    {
        $key = $this->getSessionKey();

        Redis::set($key, $result->access_token, 'EX', $result->expires_in);

        session()->put([
            "token_type" => $result->token_type,
            "expires_in" => $result->expires_in,
            "access_token" => $result->access_token,
            "refresh_token" => $result->refresh_token
        ]);

        return true;
    }

    public function hasToken() :bool
    {
        $key = $this->getSessionKey();

        if (Redis::ttl($key) == -2) {
            if (session()->has('access_token')) {
                Redis::set($key, session()->get('access_token'), 'EX', session()->get('expires_in'));
            } else {
                return false;
            }
        } elseif (Redis::ttl($key) == -1) {
            $cookies = $this->api->getLastCookies();

            $this->refreshToken($cookies);
        }

        return true;
    }

    public function getToken() :string
    {
        $key = $this->getSessionKey();

        return $this->hasToken()
            ? session()->get('token_type', 'Bearer') . ' ' . Redis::get($key)
            : '';
    }

    public function user() :?\stdClass
    {
        if (session()->has('user')) {
            return (object) session()->get('user');
        }

        return null;
    }

    public function sendResetLinkEmail(array $request)
    {
        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/password/email', $request)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function resetPassword($request)
    {
        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/password/reset', $request)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}