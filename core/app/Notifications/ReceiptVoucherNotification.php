<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReceiptVoucherNotification extends Notification
{
    use Queueable;
    private $voucher = null;
    private $general;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($voucher)
    {
        $this->voucher = $voucher;
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
            'message' => 'تم إنشاء سند القبص رقم' . ' ' . $this->voucher->receipt_num . ' ' . 'بمبلغ' . ' ' . number_format($this->voucher->amount, 2) . ' ' . $this->voucher->currency->code . ' ' . 'تاريخ العملية: ' . $this->voucher->created_at->format('n/j/Y g:i A'),
        ];
    }
}