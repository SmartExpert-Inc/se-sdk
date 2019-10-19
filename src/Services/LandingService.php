<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class LandingService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.landings.host');
    }

    public function index(array $data): ?\stdClass
    {
        $this->withAuth();

        $landins = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/landings', $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $landins;
    }

    public function store(Collection $landing)
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/landings", $landing->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function show(int $id)
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/landings/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(Request $request)
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/landings/{$request->get('id')}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function delete(int $id)
    {
        $this->withAuth();

        $landing = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/landings/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $landing;
    }
}