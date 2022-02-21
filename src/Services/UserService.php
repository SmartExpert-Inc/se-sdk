<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;
use SE\SDK\Enums\UserRoleType;

class UserService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.auth.host');
    }

    public function index(Request $request): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/users', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function update(int $userId, Request $request)
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/users/{$userId}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $user = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/users/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $user;
    }

    public function findFirst(Request $request): ?\stdClass
    {
        $user = $this->index($request);

        if (! property_exists($user, "data")) {
            return null;
        }

        return collect($user->data)->first();
    }

    public function checkPassword(int $userId, string $password): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/users/{$userId}/check-password", [
                'password' => $password
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function authUser(): ?\stdClass
    {
        if (session()->has('user')) {
            return session('user');
        }

        $this->withAuth();

        $user = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/check', null)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! property_exists($user, "data")) {
            return null;
        }

        $user = $user->data;

        if (property_exists($user, "roles")) {
            $user->roles = array_column($user->roles, null, 'name');
        }

        session()->put('user', $user);

        return $user;
    }

    public function isAdmin(): bool
    {
        $user = $this->authUser();

        if (! $user or ! property_exists($user, "roles")) {
            return false;
        }

        return array_key_exists(UserRoleType::Admin, $user->roles);
    }

    public function isAuthor(): bool
    {
        $user = $this->authUser();

        if (! $user or ! property_exists($user, "roles")) {
            return false;
        }

        return array_key_exists(UserRoleType::Author, $user->roles);
    }

    public function isTrial(): bool
    {
        $user = $this->authUser();

        if (! $user or ! property_exists($user, "roles")) {
            return false;
        }

        return array_key_exists(UserRoleType::Trial, $user->roles);
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/users/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function resetPasswordByPhone(Request $request): ?\stdClass
    {
        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/users/reset-password", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function changeStates(Request $request): ?\stdClass
    {
        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/users/change-states", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}