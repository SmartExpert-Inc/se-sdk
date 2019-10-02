<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

final class UserAttributeService extends BaseService
{
    public function get(int $userId): ?\stdClass
    {
        $this->withAuth();

        $userAttributes = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/attributes/{$userId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userAttributes;
    }

    public function update(int $userId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $userAttributes = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/attributes/{$userId}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userAttributes;
    }
}