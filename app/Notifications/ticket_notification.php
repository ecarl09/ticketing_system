<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ticket_notification extends Notification implements ShouldQueue
{
    use Queueable;
    private $ticketData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticketData)
    {
        $this->ticketData = $ticketData;
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
            ->subject($this->ticketData['subject'])
            ->greeting($this->ticketData['greetings'] .' '. ucwords($notifiable->firstName))
            ->line($this->ticketData['body'])
            ->line($this->ticketData['body2'])
            ->action($this->ticketData['notificationText'], $this->ticketData['url'])
            ->line($this->ticketData['thankyou']);
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
