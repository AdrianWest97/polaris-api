<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class packageUpdate extends Notification
{
    use Queueable;

    protected $update;
    public function __construct($update)
    {
         $this->update = $update;
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
        return (new MailMessage)->markdown('email.packageUpdate',$this->toArray());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray()
    {
        return [
            'status' => $this->update['status'],
            'message' => $this->update['message'],
            'description' => $this->update['description'],
            'package_number' => $this->update['package_number'],
            'name' => $this->update['name'],
        ];
    }

    public function toDatabase()
    {
        return $this->toArray();
    }
}