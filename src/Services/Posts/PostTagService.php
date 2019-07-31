<?php

namespace SE\SDK\Services\Posts;

use Illuminate\Support\Collection;

final class PostTagService extends BasePostService
{
    public function index(): ?Collection
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

        return collect($tags);
    }

    public function show(int $id): ?\stdClass
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $tags = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/tags/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tags;
    }
}