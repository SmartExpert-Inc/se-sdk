<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class UserService extends BaseService
{
    public function index(int $page = null): ?\stdClass
    {
        $this->withAuth();

        if (is_null($page)) {
            $page = 1;
        }

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users', [
                'page' => $page
            ])
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

    public function find(Request $request): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function findByIds(Request $request): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find-by-ids', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function findFirst(Request $request): ?\stdClass
    {
        $user = $this->find($request);

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

    public function findOne(Request $request): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function authUser(Request $request): ?\stdClass
    {
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

        return $user->data;
    }

    public function isAdmin(Request $request): bool
    {
        $user = $this->authUser($request);

        $roleName = UserRole::Admin;

        if (! $user or ! property_exists($user, "roles")) {
            return false;
        }

        return array_key_exists(ucfirst($roleName), $user->roles);
    }
}