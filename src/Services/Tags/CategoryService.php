<?php

namespace SE\SDK\Services\Tags;

use Illuminate\Http\Request;
use SE\SDK\Services\{BaseService, ApiClientService};

final class CategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.tags.host');
    }

    public function index(int $page = null): ?\stdClass
    {
        $this->withAuth();

        if (is_null($page)) {
            $page = 1;
        }

        $categories = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/categories', [
                'page' => $page
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $categories;
    }

    public function adminIndex(Request $request): ?\stdClass
    {
        $this->withAuth();

        $categories = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/admin/categories', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $categories;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $category = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/categories/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $category;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $category = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/categories", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $category;
    }

    public function update(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $category = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/categories/{$id}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $category;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $category = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/categories/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $category;
    }
}