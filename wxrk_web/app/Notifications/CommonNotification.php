<?php

namespace App\Notifications;

use App\Channels\SMS;
use App\Channels\Mail;
use App\Models\MailBox;
use Illuminate\Bus\Queueable;
use App\Services\Mailers\Mailer;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $subject;
    private $template;
    private $data;

    public function __construct($mail)
    {
        $this->subject = $mail['subject'];
        $this->template = $mail['template'];
        $this->data = $mail['data'];
        if (!empty($mail['attachment'])) {
            $this->attachment = $mail['attachment'];
        } else {
            $this->attachment = '';
        }
        if (!empty($mail['mail_cc'])) {
            $this->mail_cc = $mail['mail_cc'];
        } else {
            $this->mail_cc = false;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [Mail::class];
        // return [PushChannel::class, Mail::class,  Messenger::class, SMS::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailbox = new MailBox();
        $mailbox->mail_body = $this->data;
        $mailbox->mail_to = $notifiable->email;

        if (!empty($this->attachment)) {
            $mailbox->attachment = $this->attachment;
        }
        if (!empty($this->mail_cc)) {
            $mailbox->mail_cc = $this->mail_cc;
        }

        $mailbox->layout = $this->template;
        $mailbox->subject = $this->subject;
        $mailbox->save();

        return (new Mailer)->emailTo($mailbox);
    }

    /**
     * Get the voice representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SMS
     */
    public function toSMS($notifiable)
    {
        // $message = $this->data['mail_body'];

        // return (new Send($notifiable->mobile, $message))->sendMessage();
    }

    public function toPush($notifiable)
    {
        // push notification code
    }

    /**
     * Store notification to messenger.
     *
     * @param  mixed  $notifiable
     * @return Message
     */
    public function toMessenger($notifiable)
    {

        // return (new Message())->fill(
        //     [
        //         'receiver_id' => $notifiable->id,
        //         'messageable_type' => 'notification',
        //         'title' => $this->subject,
        //         'content' => $this->data['mail_body']
        //     ]
        // )->save();
    }
}