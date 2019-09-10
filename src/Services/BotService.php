<?php

namespace SE\SDK\Services;

use Illuminate\Support\Collection;

final class BotService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.bots.host');
    }

    public function unlink($botName, $userId)
    {
//        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/{$botName}/unlink", [
                'user_id' => $userId
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function message($botName, string $message, int $userId, ?int $ownerId)
    {
//        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/{$botName}/message", [
                'user_id' => $userId,
                'message' => $message,
                'owner_id' => $ownerId
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function store(array $data)
    {
//        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/bots", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function find(array $queryParams = []): Collection
    {
//        $this->withAut();

        $bots = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/bots/find', $queryParams)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (! property_exists($bots, "data")) {
            return collect();
        }

        return collect($bots->data);
    }
}