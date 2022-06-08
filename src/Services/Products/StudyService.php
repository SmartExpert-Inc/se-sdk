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

    public function indexCompetence(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $competences = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/{$id}/competences", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $competences;
    }

    public function indexUsers(int $id, Request $request): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/{$id}/users", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
    }

    public function showUser(int $id): ?\stdClass
    {
        $this->withAuth();

        $users = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/users/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $users;
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

    public function getCatalog(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/catalog", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function getRecommendedProducts(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/recommended", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function storeRecommendedProducts(int $productId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/study/products/{$productId}/recommended", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function getActiveProducts(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/active", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function getProducts(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/all", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function showProduct(int $productId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/{$productId}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function getFinishedProducts(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products/finished", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function getAllProducts(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/study/products", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function processLessonCommented(int $lessonId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/study/lessons/{$lessonId}/commented", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}