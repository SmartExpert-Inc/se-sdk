<?php

namespace SE\SDK\Services;

final class BotService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.bots.host');
    }

    public function unlink($botName, $userId)
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("{$botName}/unlink", [
                'user_id' => $userId
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function message($botName, $chatId, $message)
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("{$botName}/message", [
                'chat_id' => $chatId,
                'message' => $message
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function configuringWebhook($botName, $token)
    {
//        $this->headers['Authorization'] = resolve('se_sdk')->auth->getToken();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("{$botName}/webhook", [
                'token' => $token
            ])
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}