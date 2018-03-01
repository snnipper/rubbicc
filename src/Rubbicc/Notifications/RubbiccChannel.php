<?php

namespace Rubbicc\Notifications;

use Rubbicc\Notifications\RubbiccMessage;
use Rubbicc\Rubbicc;
use Illuminate\Notifications\Notification;

class RubbiccChannel
{
    /** @var Client */
    protected $client;

    /**
     * @param Rubbicc $client
     */
    public function __construct(Rubbicc $client) {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $mobile = $notifiable->routeNotificationFor('sms_rubbicc')) {
            return;
        }

        $message = $notification->toSmsApi($notifiable);

        if (is_string($message)) {
            $message = new RubbiccMessage($message);
        }

        $this->client->sendMessage($mobile,$message->content,$message->params);
    }
}