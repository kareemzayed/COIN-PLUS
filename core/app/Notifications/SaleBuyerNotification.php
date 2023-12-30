<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;

class SaleBuyerNotification extends Notification
{
    use Queueable;
    private $sale = null;
    private $general;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sale)
    {
        $this->sale = $sale;
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
            'user_id' => $this->sale->buyer_id,
            'message' => 'تم إتمام عملية بيع' . ' ' . $this->sale->item_name . ' ' . 'بمبلغ' . ' ' . $this->sale->sales_cost . ' ' . $this->general->site_currency . ' ' . 'ورصيدك الحالي هو' . ' ' . number_format($this->sale->buyer_floating_balance, 2) . ', رقم العملية هو' . ' ' . $this->sale->utr . '.',
        ];
    }
}
