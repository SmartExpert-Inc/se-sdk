<?php

namespace SE\SDK\Services\Products;

use SE\SDK\Services\BaseService;

final class StudyService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.products.host');
    }

    public function showLesson(int $id): ?\stdClass
    {
        $this->withAuth();

        $lesson = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/lessons/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $lesson;
    }

    public function getActiveProducts(): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/active")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function getFinishedProducts(): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/finished")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}