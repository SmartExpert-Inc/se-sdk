<?php

namespace SE\SDK\Services\Comments;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class CommentService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.comments.host');
    }

    public function index(Request $request): ?\stdClass
    {
        $this->withAuth();

        $comments = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/comments', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $comments;
    }

    public function update(int $commentId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $comment = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/comments/{$commentId}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $comment;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $comment = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/comments", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $comment;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $comment = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/comments/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $comment;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $comment = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/comments/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $comment;
    }

    public function getCommentsCountForCommunityPosts(Request $request): ?\stdClass
    {
        $this->withAuth();

        $likes = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/comments/community-posts", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $likes;
    }

    public function deleteForUser(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/comments/delete-for-user", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}