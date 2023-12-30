<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PurchaseSellerNotification extends Notification
{
    use Queueable;
    private $purchase = null;
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

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->purchase->seller_id,
            'message' => 'تم إتمام عملية بيع' . ' ' . $this->purchase->item_name . ' ' . 'بمبلغ' . ' ' . $this->purchase->purchase_cost . ' ' . $this->general->site_currency . ' ' . '، ورصيدك الحالي هو' . ' ' . number_format($this->purchase->seller_floating_balance, 2) . '، رقم العملية هو' . ' ' . $this->purchase->utr . '.',
        ];
    }
}
