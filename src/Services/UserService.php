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

    public function update(int $user_id, array $data)
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
            ->put('/users/' . $user_id, $data)
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

    public function find(array $query_params = []): Collection
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();
        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/users/find', $query_params)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return collect($users->data)->keyBy('id');
    }

    public function findFirst(array $query_params = []): ?\stdClass
    {
        return $this->find($query_params)->first();
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