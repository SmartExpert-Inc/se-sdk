<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class PostService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.posts.host');
    }

    public function index(int $page = null): ?\stdClass
    {
        $this->withAuth();

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

    public function update(int $postId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/posts/{$postId}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function updateStatus(int $postId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts/{$postId}/status", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

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

    public function find(Request $request): ?\stdClass
    {
        $this->withAuth();

        $posts = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/posts/find', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $posts;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

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

    public function publish(Request $request): ?\stdClass
    {
        $this->withAuth();

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/posts/publish", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }
}