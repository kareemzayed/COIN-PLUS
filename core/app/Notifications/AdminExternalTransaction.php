<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\GeneralSetting;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminExternalTransaction extends Notification
{
    use Queueable;
    private $external_transaction;
    private $general;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($external_transaction)
    {
        $this->external_transaction = $external_transaction;
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
            'message' => 'تم إنشاء المعاملة الخارجية رقم' . ' ' . $this->external_transaction->utr . ' ' . 'بمبلغ' . ' ' . number_format($this->external_transaction->amount, 2) . ' ' . $this->general->site_currency . ' ' . 'بصافي ربح' . ' ' . number_format($this->external_transaction->charge, 2) . ' ' . $this->general->site_currency . ' ' . 'للعميل' . ' ' . $this->external_transaction->customar_name . ' ' . 'تاريخ العملية: ' . $this->external_transaction->created_at->format('n/j/Y g:i A'),
        ];
    }
}