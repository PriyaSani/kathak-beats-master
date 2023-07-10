<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;


class SendLoginOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $otp;

    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$otp)
    {
        $this->otp = $otp;

        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {

        $data['otp'] = $this->otp;

        $email = $this->email;

        $subject = 'OTP for login';

        $mailer->send('mail.send_otp_mail', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);

        });
    }
}
