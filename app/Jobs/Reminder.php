<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;

class Reminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    private $workhopname;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$workhopname)
    {
        $this->email = $email;

        $this->workhopname = $workhopname;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $data = array();

        $email = $this->email;
        
        $data['workshop_name'] = $this->workhopname;

        $subject = 'New Batches & Workshops Announced for Enrolment';

        $mailer->send('mail.reminder', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);
        });
    }
}
