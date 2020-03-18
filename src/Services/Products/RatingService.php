<?php

namespace SE\SDK\Services\Products;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class RatingService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.products.host');
    }

    public function settingUpdate(int $settingId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $setting = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/rating-settings/{$settingId}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $setting;
    }

    public function getSetting(int $productId): ?\stdClass
    {
        $this->withAuth();

        $setting = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("products/{$productId}/rating-settings")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $setting;
    }

    public function storeLessonCommentedRating(Request $request): ?\stdClass
    {
        $this->withAuth();

        $setting = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("ratings/lesson-commented", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $setting;
    }

    public function index(int $productId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $ratings = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("products/{$productId}/ratings", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $ratings;
    }
}