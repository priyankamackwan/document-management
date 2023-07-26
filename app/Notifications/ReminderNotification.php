<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderNotification extends Notification
{
    use Queueable;
    private $reminderData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reminderData)
    {
        $this->reminderData = $reminderData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                ->subject('Reminder Notification')
                ->from('chirag.webpatriot@gmail.com', 'SLM FORM')
                ->greeting($this->reminderData['greeting'])
                ->line($this->reminderData['body'])
                ->action($this->reminderData['actionText'], $this->reminderData['actionURL'])
                ->line($this->reminderData['thanks']);
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
            'body' => $this->reminderData['body']
        ];
    }
}
