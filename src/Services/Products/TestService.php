<?php

namespace SE\SDK\Services\Products;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class TestService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.products.host');
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/tests", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $testId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $test = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/tests/{$testId}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $test;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $test = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tests/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $test;
    }

    public function delete(int $testId): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/tests/{$testId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}