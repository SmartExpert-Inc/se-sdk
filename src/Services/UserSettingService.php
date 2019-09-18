<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class UserSettingService extends BaseService
{
    public function get(int $userId): ?\stdClass
    {
        $this->withAut();

        $userSettings = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/settings/{$userId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userSettings;
    }

    public function update(int $userId, Request $request): ?\stdClass
    {
        $this->withAut();

        $userSettings = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/settings/{$userId}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userSettings;
    }
}