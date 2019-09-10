<?php

namespace SE\SDK\Services;

final class UserSettingService extends BaseService
{
    public function get(int $userId): ?\stdClass
    {
        $this->headers = [
            'Accept' => 'application/json',
        ];

        $this->withAut();

        $userSettings = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/settings/{$userId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userSettings->data ?? $userSettings;
    }

    public function update(int $userId, array $data): ?\stdClass
    {
        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->withAut();

        $userSettings = $this->api
            ->setHeaders($headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/settings/{$userId}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userSettings;
    }
}