<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderData;

    /**
     * Create a new message instance.
     */
    public function __construct($orderData, $productname)
    {
        $this->orderData = $orderData
        $this->productname = $productname;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Order Confirmation')
            ->view('mail.orderDetails');
    }
}