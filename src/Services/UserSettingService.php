<?php

namespace SE\SDK\Services;

final class UserSettingService extends BaseService
{
    public function get(int $user_id): ?\stdClass
    {
        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $user_settings = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/settings/' . $user_id)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $user_settings;
    }

    public function update(int $user_id, array $data): ?\stdClass
    {
        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
            'Authorization' => resolve('se_sdk')->auth->getToken(),
            'Content-Type' => 'application/json'
        ];

        $user_settings = $this->api
            ->setHeaders($headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put('/settings/' . $user_id, $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $user_settings;
    }
}