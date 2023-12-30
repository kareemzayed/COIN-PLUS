<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSendReportNotification extends Notification
{
    use Queueable;
    private $report;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($report)
    {
        $this->report = $report;
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
            'user_id' => $this->report->user_id,
            'message' => 'تم تقديم الابلاغ بخصوص العملية رقم' . ' ' . $this->report->transaction_utr . ' ' . 'رقم الابلاغ هو' . ' ' . $this->report->utr . '.',
        ];
    }
}
