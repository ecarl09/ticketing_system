<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newsNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $notifData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifData)
    {
        $this->notifData = $notifData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->notifData['subject'])
            ->greeting($this->notifData['greetings'])
            ->line($this->notifData['body'])
            ->line($this->notifData['body1'])
            ->action($this->notifData['notificationText'], $this->notifData['url'])
            ->line($this->notifData['thankyou']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
