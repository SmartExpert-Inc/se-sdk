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
    public function index(int $page = null): ?\stdClass
    {
//        $this->withAut();

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

        $this->badResponse($tags);

        return $tags;
    }

    public function show(int $id): ?\stdClass
    {
//        $this->withAut();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($tag);

        return $tag->data;
    }

    public function getCategories(): ?Collection
    {
//        $this->withAut();

        $categories = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/categories')
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($categories);

        return collect($categories->data);
    }

    public function getCategory(int $id): ?\stdClass
    {
//        $this->withAut();

        $category = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/categories/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($category);

        return $category->data;
    }

    public function store(array $data): ?\stdClass
    {
//        $this->withAut();

        if (! isset($data['name'])) {
            return null;
        }

        if (! isset($data['slug'])) {
            $data['slug'] = str_slug($data['name']);
        }

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/tags", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($response);

        return $response;
    }

    public function update(int $id, array $data): ?\stdClass
    {
//        $this->withAut();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/tags/{$id}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($tag);

        return $tag;
    }

    public function delete(int $id): ?\stdClass
    {
//        $this->withAut();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/tags/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($tag);

        return $tag;
    }

    public function find(array $data): ?\stdClass
    {
//        $this->withAut();

        $tags = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/find", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        $this->badResponse($tags);

        return $tags;
    }
}