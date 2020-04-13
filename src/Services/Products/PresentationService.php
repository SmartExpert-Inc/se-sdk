<?php

namespace SE\SDK\Services\Products;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class PresentationService extends BaseService
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
            ->post("/presentations", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $presentationId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $presentation = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/presentations/{$presentationId}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $presentation;
    }

    public function show(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $presentation = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/presentations/{$id}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $presentation;
    }

    public function delete(int $presentationId): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/presentations/{$presentationId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}