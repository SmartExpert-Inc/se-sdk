<?php

namespace SE\SDK\Services;

use Illuminate\Support\Collection;

final class BotChatService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.bots.host');
    }

    public function store(array $data)
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/chats", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function find(array $query_params = []): Collection
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $chats = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/chats/find', $query_params)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return collect($chats->data);
    }
}