<?php

namespace SE\SDK\Services;

use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Illuminate\Support\Facades\Log;

final class ApiClientService
{
    /** @var Client $client */
    private $client;

    /** @var array $methods */
    private $methods = [
        'get', 'post', 'put', 'delete'
    ];

    /** @var string $baseUrl */
    private $baseUrl;

    /** @var string $prefix */
    private $prefix;

    /** @var array $response */
    private $response;

    /** @var array $headers */
    private $headers = [];

    /** @var array $cookies */
    private $cookies;

    public function __construct()
    {
        $this->client = requests();
    }

    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = $url;

        return $this;
    }

    private function getPath(array $arguments): string
    {
        return $arguments[0];
    }

    private function getParams(array $arguments): ?array
    {
        $params = [];

        if (isset($arguments[1]) and is_array($arguments[1])) {
            return $arguments[1];
        }

        return $params;
    }

    private function setResults(?\stdClass $results): void
    {
        $this->response = $results;
    }

    private function setCookies(\stdClass $results)
    {
        $headers = $results->getHeaders();

        if (isset($headers) && array_key_exists('Set-Cookie', $headers)) {
            $this->cookies = $headers['Set-Cookie'];
        }
    }

    public function getLastCookies()
    {
        return $this->cookies;
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function dropUrls()
    {
        $this->baseUrl = null;
        $this->prefix = null;
    }

    public function dropState()
    {
        $this->response = null;
        $this->cookies = [];
        $this->headers = [];
    }

//    public function getObject(): \stdClass
//    {
//        if ($this->response) {
//            return (object) $this->response;
//        }
//
//        return new \stdClass;
//    }

    public function setHeaders(array $headers): self
    {
        foreach ($headers as $name => $value) {
            $this->headers[$name] = $value;
        }

        return $this;
    }

    public function __call($name, $arguments)
    {
        if (! in_array($name, $this->methods)) {
            $message = __("Method \":name\" not allowed!", ['name' => $name]);

            throw new MethodNotAllowedException($this->methods, $message);
        }

        $payload = $this->getParams($arguments);
        $headers = $this->headers;
        $path = $this->getPath($arguments);
        $url = "{$this->baseUrl}{$this->prefix}{$path}";

        $results = $this->client->{$name}($url, $payload, $headers);
//        $this->setCookies($results);
        $res = (object) $results->body;
        $this->setResults($res);

        return $this;
    }
}