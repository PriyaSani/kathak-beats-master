<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;

class ScheduleChange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $email;
    
    private $name;
    
    private $date;
    
    private $time;

    public function __construct($email,$name,$date,$time)
    {
        $this->email = $email;

        $this->name = $name;

        $this->date = $date;

        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $data['date'] = $this->date;
        $data['time'] = $this->time;
        $data['name'] = $this->name;

        $email = $this->email;

        $subject = 'Change in Batch/Workshop Schedule';

        $mailer->send('mail.schedule_change', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);

        });
    }
}
