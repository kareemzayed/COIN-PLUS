<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SaleAdminNotification extends Notification
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
            'message' => $this->sale->item_name . ' ' . 'تم بيعه من الصندوق' . ' ' . $this->sale->fund->name . ' ' . 'بمبلغ' . ' ' . number_format($this->sale->amount, 2) . ' ' . $this->general->site_currency . ' ' . 'للمستخدم' . ' ' . $this->sale->buyer->fname . ' ' . $this->sale->buyer->lname . ' ' . 'بمبلغ' . ' ' . number_format($this->sale->sales_cost, 2) . ' ' . $this->general->site_currency . ', بصافي ربح قدره' . ' ' . number_format($this->sale->charge, 2) . ' ' . $this->general->site_currency . ' ' . 'رقم العملية: ' . $this->sale->utr . ' ' . 'تاريخ العملية: ' . $this->sale->created_at->format('n/j/Y g:i A'),
        ];
    }
}
