<?php

namespace SE\SDK\Services\Posts;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class StatisticService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.posts.host');
    }

    public function update(int $statisticId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $post = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/statistics/{$statisticId}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $post;
    }
}