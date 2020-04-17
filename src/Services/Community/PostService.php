<?php

namespace SE\SDK\Services\Community;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class PostService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.community.host');
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $grade = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/posts/{$id}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $grade;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/posts/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/posts/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}