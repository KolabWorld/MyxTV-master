<?php

namespace App\Channels;

use App\Helpers\GeneralHelper;
use Illuminate\Notifications\Notification;

class PushChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $notification->toPush($notifiable);
    }
}