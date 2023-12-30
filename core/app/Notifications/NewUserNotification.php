<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    private $user = null;

    public function __construct($user)
    {
        $this->user = $user;
    }


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->fullname . ' قام بالتسجيل للتو',
        ];
    }
}
