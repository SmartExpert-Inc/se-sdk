<?php

namespace SE\SDK\Services\Comments;

use Illuminate\Http\Request;
use SE\SDK\Services\{
    ApiClientService, BaseService
};

final class RepostService extends BaseService
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

        $repost = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/reposts", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $repost;
    }

    public function delete(int $id): ?\stdClass
    {
        $this->withAuth();

        $repost = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/reposts/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $repost;
    }
}