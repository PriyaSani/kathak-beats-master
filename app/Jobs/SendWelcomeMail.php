<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;

class SendWelcomeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    private $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$name)
    {   
        $this->name = $name;

        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->email;

        $data['name'] = $this->name;

        $subject = 'Welcome to KathakBeats';

        $mailer->send('mail.send_welcome_mail', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);

        });
    }
}
