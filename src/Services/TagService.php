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

        if (property_exists($tags, 'data')) {
            return collect($tags->data);
        }
        return null;
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
}