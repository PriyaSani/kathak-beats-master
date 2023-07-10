<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;

class BatchEnrollment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    private $workshopname;

    private $studentname;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($studentname,$workshopname,$email)
    {
        $this->email = $email;

        $this->studentname = $studentname;

        $this->workshopname = $workshopname;
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

        $subject = 'Welcome to KathakBeats';

        $mailer->send('mail.course_update', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);
        });
    }
}
