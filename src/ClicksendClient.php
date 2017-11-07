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
        if (empty($message->originator)) {
            $message->setOriginator(config('services.clicksend.originator'));
        }
        if (empty($message->recipients)) {
            $message->setRecipients(config('services.clicksend.recipients'));
        }

        try {
            dd($message->toJson());
            // $this->client->request('POST', 'https://rest.clicksend.com/v3/', [
            //     'body' => $message->toJson(),
            //     'headers' => [
            //         'Content-type' => 'application/json',
            //         'Authorization' => "Basic " . base64_encode("{$this->access_user}:{$this->access_key}"),
            //     ],
            // ]);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
