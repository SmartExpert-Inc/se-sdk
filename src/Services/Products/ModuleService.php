<?php

namespace SE\SDK\Services\Products;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class ModuleService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.products.host');
    }

    public function index(int $productId): ?\stdClass
    {
        $this->withAuth();

        $modules = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/products/{$productId}/modules")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $modules;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/modules", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $moduleId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $module = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/modules/{$moduleId}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $module;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $module = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/modules/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $module;
    }

    public function delete(int $moduleId): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/modules/{$moduleId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function order(int $productId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/products/{$productId}/modules/order", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}