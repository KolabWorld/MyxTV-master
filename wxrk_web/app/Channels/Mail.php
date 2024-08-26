<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class Mail
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
        $notification->toMail($notifiable);
    }
}