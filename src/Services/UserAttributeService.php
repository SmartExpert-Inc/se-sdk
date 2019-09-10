<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use SE\SDK\Facades\SeSDK;

final class UserAttributeService extends BaseService
{
    public function get(int $user_id): ?\stdClass
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $userAttributes = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/attributes/' . $user_id)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userAttributes->data ?? $userAttributes;
    }

    public function update(int $user_id, array $data): ?\stdClass
    {
        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Authorization' => resolve('se_sdk')->auth->getToken(),
            'Content-Type' => 'application/json'
        ];

        $userAttributes = $this->api
            ->setHeaders($headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put('/attributes/' . $user_id, $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userAttributes;
    }
}