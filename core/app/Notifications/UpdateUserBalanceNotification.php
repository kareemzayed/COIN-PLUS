<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateUserBalanceNotification extends Notification
{
    use Queueable;
    private $updated_balance;
    private $type;
    private $general;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($updated_balance, $type)
    {
        $this->updated_balance = $updated_balance;
        $this->type = $type;
        $this->general = GeneralSetting::first();
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
        if ($this->type == 'add') {
            return [
                'user_id' => $this->updated_balance->user_id,
                'message' => 'تمت إضافة مبلغ قدره' . ' ' . number_format($this->updated_balance->amount, 2) . ' ' . $this->general->site_currency . ' ' . 'إلى حسابك. رصيدك الحالي هو' . ' ' . number_format($this->updated_balance->floating_balance, 2) . ' ' . $this->general->site_currency . ', رقم العملية هو' . ' ' . $this->updated_balance->utr . '.',
            ];
        } else {
            return [
                'user_id' => $this->updated_balance->user_id,
                'message' => 'تم خصم مبلغ قدره' . ' ' . number_format($this->updated_balance->amount, 2) . ' ' . $this->general->site_currency . ' ' . 'من حسابك. رصيدك الحالي هو' . ' ' . number_format($this->updated_balance->floating_balance, 2) . ' ' . $this->general->site_currency . ', رقم العملية هو' . ' ' . $this->updated_balance->utr . '.',
            ];
        }
    }
}
