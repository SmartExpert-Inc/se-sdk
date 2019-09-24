<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class UserService extends BaseService
{
    public function index(int $page = null): ?\stdClass
    {
        $this->withAut();

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
        $this->withAut();

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
        $this->withAut();

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
        $this->withAut();

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
        $this->withAut();

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
        $this->withAut();

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

    public function exists(Request $request): ?bool
    {
        $this->withAut();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/exists', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! property_exists($users, "scalar")) {
            return false;
        }

        if ($users->scalar == "Found") {
            return true;
        }

        return false;
    }

    public function checkPassword(int $userId, string $password): ?\stdClass
    {
        $this->withAut();

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
}