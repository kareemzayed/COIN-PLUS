<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DirectPurchaseSellerNotification extends Notification
{
    use Queueable;
    private $purchase;
    private $general;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
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
        return [
            'user_id' => $this->purchase->seller_id,
            'message' => 'تم إتمام عملية بيع' . ' ' . $this->purchase->item_name . ' ' . 'بمبلغ' . ' ' . $this->purchase->purchase_cost . ' ' . $this->general->site_currency . ' ' . '، ورصيدك الحالي هو' . ' ' . number_format($this->purchase->seller_floating_balance, 2) . ' ' . $this->general->site_currency . '، رقم العملية هو' . ' ' . $this->purchase->utr . '.',
        ];
    }
}
