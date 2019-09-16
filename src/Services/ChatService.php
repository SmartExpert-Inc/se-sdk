<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class ChatService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.bots.host');
    }

    public function store(Request $request): ?\stdClass
    {
//        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/chats", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function find(Request $request): ?\stdClass
    {
//        $this->withAut();

        $chats = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/chats/find', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $chats;
    }
}