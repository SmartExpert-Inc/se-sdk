<?php

namespace SE\SDK\Services\Comments;

use Illuminate\Http\Request;
use SE\SDK\Services\{
    ApiClientService, BaseService
};

final class LikeService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.comments.host');
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $like = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/likes", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $like;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $like = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/likes/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $like;
    }
}