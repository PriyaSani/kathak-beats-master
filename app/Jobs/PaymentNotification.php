<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;

class PaymentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    private $amount;

    private $paymentId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$amount,$paymentId)
    {
        $this->email = $email;

        $this->amount = $amount;

        $this->paymentId = $paymentId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        $data['amount'] = $this->amount;

        $data['payment_id'] = $this->paymentId;

        $subject = 'Payment Success';

        $mailer->send('mail.payment_notification', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);
        });
    }
}
