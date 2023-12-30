<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PurchaseAdminNotification extends Notification
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
            'message' => 'تم شراء' . ' ' . $this->purchase->item_name . ' ' . 'من المستخدم أو التاجر' . ' ' . $this->purchase->seller->fname . ' ' . $this->purchase->seller->lname . ' ' . 'بمبلغ' . ' ' . number_format($this->purchase->purchase_cost, 2) . ' ' . $this->general->site_currency . ', وتم بيعه إلى المستخدم' . ' ' . $this->purchase->buyer->fname . ' ' . $this->purchase->buyer->lname . ' ' . 'بمبلغ' . ' ' . number_format($this->purchase->sales_cost, 2) . ' ' . $this->general->site_currency . ', مع صافي ربح قدره' . ' ' . number_format($this->purchase->charge, 2) . ' ' . $this->general->site_currency . ' ' . 'رقم العملية: ' . $this->purchase->utr . ' ' . 'تاريخ العملية: ' . $this->purchase->created_at->format('n/j/Y g:i A'),
        ];
    }
}
