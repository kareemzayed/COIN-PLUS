<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCheckRememberNotification extends Notification
{
    use Queueable;
    private $check;
    private $days;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($check, $days)
    {
        $this->check = $check;
        $this->days = $days;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'الشيك رقم #' . $this->check->check_num . ' ' . 'متبقي علي تاريخ استحقاقه' . ' ' . $this->days . ' ' . 'أيام.' . 'تاريخ استحقاق الشيك هو' . ' ' . $this->check->due_date . '. ' . 'الرجاء المراجعة.',
        ];
    }
}
