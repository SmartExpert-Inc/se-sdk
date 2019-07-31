<?php

namespace SE\SDK\Services\Posts;

final class PostService extends BasePostService
{
    public function index(int $page = 1): ?\stdClass
    {
        $posts = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/posts', [
                'page' => $page
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $posts;
    }

    public function update(int $post_id, array $data)
    {
        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
        ];

        if (array_key_exists("_token", $data)) {
            unset($data['_token']);
        }

        if (array_key_exists("_method", $data)) {
            unset($data['_method']);
        }

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/posts/{$post_id}", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function store(array $data)
    {
        $this->headers = [
            'Accept' => 'application/json',
        ];

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function updateStatus(int $postId, array $data)
    {
        $this->headers = [
            'Accept' => 'application/json',
        ];

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts/{$postId}/status", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function show(int $id): ?\stdClass
    {
        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/posts/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function find(array $query_params = []): ?\stdClass
    {
        $posts = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/posts/find', $query_params)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $posts;
    }

    public function delete(int $id): ?\stdClass
    {
        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/posts/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function publish(array $data)
    {
        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts/publish", $data)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }
}