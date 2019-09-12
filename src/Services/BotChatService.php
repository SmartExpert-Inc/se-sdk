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
//        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/chats", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($response);

        return $response;
    }

    public function find(array $queryParams = []): Collection
    {
//        $this->withAut();

        $chats = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/chats/find', $queryParams)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($chats, collect());

        return $chats->data ? collect($chats->data) : collect();
    }
}