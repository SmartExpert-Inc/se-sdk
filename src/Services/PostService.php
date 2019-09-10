<?php

namespace SE\SDK\Services;

final class PostService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.posts.host');

        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
//            'Authorization' => resolve('se_sdk')->auth->getToken(),
//            'Content-Type' => 'application/json'
        ];
    }

    public function index(int $page = null): ?\stdClass
    {
//        $this->withAut();

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

    public function update(int $postId, array $data)
    {
        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
        ];

//        $this->withAut();

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
            ->put("/posts/{$postId}", $data)
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

//        $this->withAut();

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

//        $this->withAut();

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
//        $this->withAut();

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

    public function find(array $queryParams = []): ?\stdClass
    {
//        $this->withAut();

        $posts = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/posts/find', $queryParams)
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $posts;
    }

    public function delete(int $id): ?\stdClass
    {
//        $this->withAut();

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
//        $this->withAut();

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