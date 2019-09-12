<?php

namespace SE\SDK\Services;

use Illuminate\Support\Collection;

final class UserService extends BaseService
{
    public function index(int $page = 1): ?\stdClass
    {
        $this->withAut();

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

        $this->badResponse($users);

        return $users;
    }

    public function store(array $data)
    {
        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->withAut();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/users', $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($users);

        return $users;
    }

    public function update(int $userId, array $data)
    {
        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->withAut();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/users/{$userId}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($users);

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

        $this->badResponse($user);

        return $user->data ?? $user;
    }

    public function find(array $queryParams = []): ?\stdClass
    {
        $this->withAut();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find', $queryParams)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($users);

        return $users;
    }

    public function findByIds(array $queryParams = []): ?\stdClass
    {
        $this->withAut();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find-by-ids', $queryParams)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($users);

        return $users;
    }

    public function findFirst(array $queryParams = []): ?\stdClass
    {
        return collect($this->find($queryParams)->data)->first();
    }

    public function checkPassword(int $userId, string $password): ?\stdClass
    {
        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/check-password/{$userId}", [
                'password' => $password
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($response);

        return $response;
    }
}