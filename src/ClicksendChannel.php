<?php

namespace NotificationChannels\Clicksend;

use Illuminate\Notifications\Notification;

class ClicksendChannel
{
    /** @var \NotificationChannels\Clicksend\ClicksendClient */
    protected $client;

    public function __construct(ClicksendClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Clicksend\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toClicksend($notifiable);

        if (is_string($message)) {
            $message = ClicksendMessage::create($message);
        }

        if ($to = $notifiable->routeNotificationFor('clicksend')) {
            $message->setRecipients($to);
        }

        $this->client->send($message);
    }
}
