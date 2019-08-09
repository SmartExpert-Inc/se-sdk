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

    public function getTags(): ?Collection
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $tags = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/tags')
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return collect($tags->data);
    }

    public function getTag(int $id): ?\stdClass
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

        return $tag->data;
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

        return collect($categories->data);
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

        return $category->data;
    }
}