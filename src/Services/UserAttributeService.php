<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use SE\SDK\Facades\SeSDK;

final class UserAttributeService extends BaseService
{
    public function get(int $userId): ?\stdClass
    {
        $this->withAut();

        $userAttributes = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/attributes/{$userId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($userAttributes);

        return $userAttributes->data ?? $userAttributes;
    }

    public function update(int $userId, array $data): ?\stdClass
    {
        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->withAut();

        $userAttributes = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/attributes/{$userId}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($userAttributes);

        return $userAttributes;
    }
}