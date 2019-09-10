<?php

namespace SE\SDK\Services;

final class UserSettingService extends BaseService
{
    public function get(int $userId): ?\stdClass
    {
        $this->headers = [
            'Authorization' => resolve('se_sdk')->auth->getToken(),
            'Accept' => 'application/json',
        ];

        $userSettings = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/settings/{$userId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $userSettings->data;
    }

    public function update(int $userId, array $data): ?\stdClass
    {
        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Authorization' => resolve('se_sdk')->auth->getToken(),
            'Content-Type' => 'application/json'
        ];

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