<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class GlobalRatingService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.platform.host');
    }

    public function update(Request $request): ?\stdClass
    {
        $this->withAuth();

        $rating = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/ratings/update", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $rating;
    }

    public function deleteForProduct(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/ratings/delete-for-product", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}