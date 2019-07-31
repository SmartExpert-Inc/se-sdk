<?php

namespace SE\SDK\Services\Posts;

final class CategoryService extends BasePostService
{
    public function index(int $page = 1): ?\stdClass
    {
        $posts = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/categories', [
                'page' => $page
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $posts;
    }

    public function show(int $id): ?\stdClass
    {
        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/categories/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }
}