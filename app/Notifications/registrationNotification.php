<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class registrationNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $registrationData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($registrationData)
    {
        $this->registrationData = $registrationData;
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
                    ->subject($this->registrationData['subject'])
                    ->greeting($this->registrationData['greetings'])
                    ->line($this->registrationData['body'])
                    ->line($this->registrationData['body0'])
                    ->line($this->registrationData['body1'])
                    ->line($this->registrationData['body2'])
                    ->line($this->registrationData['body3'])
                    ->action($this->registrationData['notificationText'], $this->registrationData['url'])
                    ->line($this->registrationData['thankyou']);
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
