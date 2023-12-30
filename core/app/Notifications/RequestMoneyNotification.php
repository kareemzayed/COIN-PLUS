<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestMoneyNotification extends Notification
{
    use Queueable;
    private $money = null;

  
    public function __construct($money)
    {
        $this->money = $money;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->money->request_user_id,
            'message' => $this->money->sender->username.' requested money of : '.$this->money->request_amount
        ];
    }
}
