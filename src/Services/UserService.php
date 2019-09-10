<?php

namespace SE\SDK\Services;

use Illuminate\Support\Collection;

final class UserService extends BaseService
{
    public function index(int $page = 1): ?\stdClass
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

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

    public function store(array $data)
    {
        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Authorization' => resolve('se_sdk')->auth->getToken(),
            'Content-Type' => 'application/json'
        ];

        $users = $this->api
            ->setHeaders($headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/users', $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function update(int $userId, array $data)
    {
        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Authorization' => resolve('se_sdk')->auth->getToken(),
            'Content-Type' => 'application/json'
        ];

        $users = $this->api
            ->setHeaders($headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/users/{$userId}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function show(int $id): ?\stdClass
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $user = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/users/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $user->data;
    }

    public function find(array $queryParams = []): ?\stdClass
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();
        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find', $queryParams)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function findFirst(array $queryParams = []): ?\stdClass
    {
        return collect($this->find($queryParams)->data)->first();
    }

    public function checkPassword(int $userId, string $password): ?\stdClass
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();
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

        return $response;
    }
}