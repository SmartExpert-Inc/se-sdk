<?php

namespace SE\SDK\Services\Tags;

use Illuminate\Http\Request;
use SE\SDK\Services\{BaseService, ApiClientService};

final class TagService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.tags.host');
    }
    public function index(int $page = null): ?\stdClass
    {
        $this->withAuth();

        if (is_null($page)) {
            $page = 1;
        }

        $tags = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/tags', [
                'page' => $page
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tags;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/tags", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/tags/{$id}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/tags/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }

    public function find(Request $request): ?\stdClass
    {
        $this->withAuth();

        $tags = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/find", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tags;
    }
}