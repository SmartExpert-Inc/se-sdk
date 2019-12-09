<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class ChatService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.bots.host');
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

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
        $this->withAuth();

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