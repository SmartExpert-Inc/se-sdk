<?php

namespace SE\SDK\Services\Posts;

use Illuminate\Support\Collection;

final class PostCategoryService extends BasePostService
{
    public function index(): ?Collection
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

        return collect($categories);
    }
}