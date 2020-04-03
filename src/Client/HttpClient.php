<?php

namespace SE\SDK\Client;

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Illuminate\Support\Facades\Log;

final class HttpClient
{
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';
    const PUT_METHOD = 'PUT';
    const DELETE_METHOD = 'DELETE';

    /** @var resource */
    private $channel;

    /** @var array $options */
    private $options;

    /** @var string $useragent */
    private $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';

    /** @var int $maxRedirects */
    private $maxRedirects = 4;

    /** @var int $connectTimeout */
    private $connectTimeout = 30;

    /** @var array $methods */
    private $methods = [
        self::GET_METHOD,
        self::POST_METHOD,
        self::PUT_METHOD,
        self::DELETE_METHOD
    ];

    public function __construct($options=[])
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return false|resource
     */
    private function init()
    {
        if (! is_resource($this->channel)) {
            $this->channel = curl_init();
            curl_setopt($this->channel,CURLOPT_MAXREDIRS, $this->maxRedirects);
            curl_setopt($this->channel,CURLOPT_USERAGENT, $this->useragent);
            curl_setopt($this->channel,CURLOPT_CONNECTTIMEOUT,$this->connectTimeout);
            curl_setopt($this->channel,CURLOPT_TIMEOUT, $this->connectTimeout);
            curl_setopt($this->channel,CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($this->channel,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($this->channel,CURLOPT_HEADER, true);
            curl_setopt($this->channel,CURLOPT_NOBODY, false);

            curl_setopt($this->channel,CURLOPT_AUTOREFERER, true);
            curl_setopt($this->channel,CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->channel,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->channel,CURLOPT_VERBOSE, true);

            curl_setopt($this->channel, CURLINFO_HEADER_OUT, true);
        }

        return $this->channel;
    }

    private function isGetMethod(string $method): bool
    {
        return strtoupper($method) == self::GET_METHOD;
    }

    private function isPostMethod(string $method): bool
    {
        return strtoupper($method) == self::POST_METHOD;
    }

    private function isPutMethod(string $method): bool
    {
        return strtoupper($method) == self::PUT_METHOD;
    }

    private function isDeleteMethod(string $method): bool
    {
        return strtoupper($method) == self::DELETE_METHOD;
    }

    private function getData(array $arguments): ?string
    {
        $data = null;

        if (isset($arguments[1])) {
            $data = $arguments[1];
        }

        if (is_array($data)) {
            $data = http_build_query($data, '', '&');
        }

        return $data;
    }

    private function getHeaders(array $arguments): ?array
    {
        $headers = [];

        if (isset($arguments[2]) and is_array($arguments[2])) {
            return $arguments[2];
        }

        return $headers;
    }

    /**
     * @param array $arguments
     * @return string
     * @throws \Exception
     */
    private function getUrl(array $arguments): string
    {
        if (isset($arguments[0])) {
            return $arguments[0];
        }

        throw new \Exception('Url not set');
    }

    private function setRequestHeaders($headers=[]): void
    {
        if ($headers) {
            $arr = [];
            foreach ($headers as $header => $value) {
                $arr[] = "{$header}: {$value}";
            }

            if ($arr) {
//                $dataString = json_encode($arr);
//                $arr[] = 'Content-Length: ' . strlen($dataString);
                curl_setopt($this->channel, CURLOPT_HTTPHEADER, $arr);
            }
        }
    }

    private function sendRequest(): ?\stdClass
    {
        $response = null;
        $body = null;

        curl_setopt($this->channel, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);

            // ignore invalid headers
            if (count($header) < 2) {
                return $len;
            }

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        });

        $response = curl_exec($this->channel);
        $httpCode = curl_getinfo($this->channel, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($this->channel, CURLINFO_HEADER_SIZE);

//        TODO: Add this to debug method
//        $headerSent = curl_getinfo($this->channel, CURLINFO_HEADER_OUT);

        $body = substr($response, $headerSize);

        $errno = curl_errno($this->channel);
        $error = curl_error($this->channel);

        if (is_resource($this->channel)) {
            curl_close($this->channel);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $this->formatResponse($body, $httpCode, $headers);
    }

    private function formatResponse(string $body, int $httpCode, ?array $headers): \stdClass
    {
        if ($headers && array_key_exists("content-type", $headers)) {
            foreach ($headers["content-type"] as $header) {
                if ($header == "application/json") {
                    $body = json_decode($body);
                }
            }
        }

//        if (app()->environment() !== "production") {
//            Log::debug(print_r($body, true));
//        }

        $response = new \stdClass();
        $response->body = $body;
        $response->code = $httpCode;
        $response->headers = $headers;

        return $response;
    }

    public function __call($name, $arguments): ?\stdClass
    {
        if (count($arguments) < 1) {
            throw new \InvalidArgumentException('Magic request methods require a URI and optional options array');
        }

        if (! in_array(strtoupper($name), $this->methods)) {
            $message = __("Method \":name\" not allowed!", ['name' => $name]);

            throw new MethodNotAllowedException($this->methods, $message);
        }

        /** @var resource type channel */
        $this->channel = $this->init();

        $url = $this->getUrl($arguments);
        $data = $this->getData($arguments);
        $headers = $this->getHeaders($arguments);

        if ($this->isGetMethod($name)) {
            if ($data) {
                $url .= "?{$data}";
            }
        }

        if ($this->isPostMethod($name)) {
            curl_setopt($this->channel, CURLOPT_POST, true);
            curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, self::POST_METHOD);
            curl_setopt($this->channel, CURLOPT_POSTFIELDS, $data);
        }

        if ($this->isPutMethod($name)) {
            curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, self::PUT_METHOD);
            curl_setopt($this->channel, CURLOPT_POSTFIELDS, $data);
        }

        if ($this->isDeleteMethod($name)) {
            curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, self::DELETE_METHOD);
            curl_setopt($this->channel, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($this->channel, CURLOPT_URL, $url);

        $this->setRequestHeaders($headers);

        return $this->sendRequest();
    }
}