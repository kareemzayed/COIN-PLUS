<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminTransactionWithCurrencyNotification extends Notification
{
    use Queueable;
    private $transaction_with_currency;
    private $general;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction_with_currency)
    {
        $this->transaction_with_currency = $transaction_with_currency;
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
            'message' => 'تم إنشاء معاملة' . ' ' .  (($this->transaction_with_currency->trans_type == 1) ? 'شراء' : 'بيع')  . ' ' . 'بمبلغ' . ' ' . number_format($this->transaction_with_currency->amount_in_base_currency, 2) . ' ' . $this->general->site_currency . ' ' . 'مقابل مبلغ' . ' ' . number_format($this->transaction_with_currency->amount_in_other_currency, 2) . ' ' . $this->transaction_with_currency->currency->code . ', بصافي ربح قدره' . ' ' . number_format($this->transaction_with_currency->charge, 2) . ' ' . $this->general->site_currency . ' ' . 'رقم العملية: ' . $this->transaction_with_currency->utr . ' ' . 'تاريخ العملية: ' . $this->transaction_with_currency->created_at->format('n/j/Y g:i A'),
        ];
    }
}