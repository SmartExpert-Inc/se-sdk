<?php

namespace SE\SDK\Services;

use Illuminate\Support\Collection;

final class TagService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.tags.host');
    }
    public function index(int $page = 1): ?\stdClass
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

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
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (property_exists($tag, 'data')) {
            return $tag->data;
        }
        return null;
    }

    public function getCategories(): ?Collection
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $categories = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/categories')
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (property_exists($categories, 'data')) {
            return collect($categories->data);
        }
        return null;
    }

    public function getCategory(int $id): ?\stdClass
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $category = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/categories/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        if (property_exists($category, 'data')) {
            return $category->data;
        }
        return null;
    }

    public function store(array $data): ?\stdClass
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/tags", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $id, array $data): ?\stdClass
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/tags/{$id}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }

    public function delete(int $id): ?\stdClass
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

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

    public function find(array $data): Collection
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $tags = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/find", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return collect($tags);
    }
}