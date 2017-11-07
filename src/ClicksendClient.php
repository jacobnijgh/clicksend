<?php

namespace NotificationChannels\Clicksend;

use Exception;
use GuzzleHttp\Client;
use NotificationChannels\Clicksend\Exceptions\CouldNotSendNotification;

class ClicksendClient
{
    protected $client;

    protected $access_user;

    protected $access_key;

    /**
     * ClicksendClient constructor.
     * @param Client $client
     * @param $access_key string API Key from Clicksend API
     */
    public function __construct(Client $client, $access_user, $access_key)
    {
        $this->client = $client;
        $this->access_user = $access_user;
        $this->access_key = $access_key;
    }

    /**
     * Send the Message.
     * @param ClicksendMessage $message
     * @throws CouldNotSendNotification
     */
    public function send(ClicksendMessage $message)
    {
        if (empty($message->from)) {
            $message->setFrom(config('services.clicksend.from'));
        }
        if (empty($message->to)) {
            $message->setRecipient(config('services.clicksend.recipient'));
        }

        try {
            return $this->client->request('POST', 'https://rest.clicksend.com/v3/sms/send', [
                'body' => $message->toJson(),
                'headers' => [
                    'Content-type' => 'application/json',
                    'Authorization' => "Basic " . base64_encode("{$this->access_user}:{$this->access_key}"),
                ],
            ]);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
