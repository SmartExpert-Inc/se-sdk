<?php

namespace SE\SDK\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
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

    public function __construct(Client $client)
    {
        $this->client = $client;
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

    private function setCookies(ResponseInterface $results)
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

    public function getObject(): \stdClass
    {
        if ($this->response) {
            return (object) $this->response;
        }

        return new \stdClass;
    }

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

        $options['headers'] = $this->headers;
        $path = $this->getPath($arguments);
        $url = "{$this->baseUrl}{$this->prefix}{$path}";

        $params = $this->getParams($arguments);
        if (in_array($name, ['get', 'put']) and $params) {
            $uriParams = http_build_query($params);
            $url .= "?{$uriParams}";
        }

        try {
            if (! in_array($name, ['get', 'put']) and $params) {
                $options['form_params'] = $params;
            }

            $results = $this->client->request($name, $url, $options);
            $this->setCookies($results);
            $res = (object) \GuzzleHttp\json_decode($results->getBody()->getContents());
            $this->setResults($res);
        } catch (RequestException $e) {
            Log::error("{$e->getCode()}: {$e->getMessage()}\n{$e->getLine()}: {$e->getFile()}");

            $res = [];

            try {
                $res = null;
                if ($e->hasResponse()) {
                    $res = (object) \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
                }
            } catch (\Exception $e) {
                Log::error("{$e->getCode()}: {$e->getMessage()}\n{$e->getLine()}: {$e->getFile()}");
            }

            $this->setResults($res);
        } catch (\Exception $e) {
            Log::error("{$e->getCode()}: {$e->getMessage()}\n{$e->getLine()}: {$e->getFile()}");

            $res = null;
            $this->setResults($res);
        }

        return $this;
    }
}