<?php

namespace SE\SDK\Services\Products;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class StudyService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.products.host');
    }

    public function showLesson(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $lesson = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/lessons/{$id}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $lesson;
    }

    public function indexLesson(int $id): ?\stdClass
    {
        $this->withAuth();

        $lessons = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/modules/{$id}/lessons")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $lessons;
    }

    public function indexModule(int $id): ?\stdClass
    {
        $this->withAuth();

        $modules = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/{$id}/modules")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $modules;
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