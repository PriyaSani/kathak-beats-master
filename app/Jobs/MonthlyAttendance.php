<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailer;

class MonthlyAttendance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $total;

    private $attended;

    private $month;

    private $email;

    private $workshop;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$total,$attended,$month,$workshop)
    {
        $this->email = $email;

        $this->total = $total;

        $this->attended = $attended;

        $this->month = $month;

        $this->workshop = $workshop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {   

        $data['total'] = $this->total;
        $data['attended'] = $this->attended;
        $data['month'] = $this->month;
        $data['workshop'] = $this->workshop;

        $email = $this->email;

        $subject = 'Monthly Attendance Details';

        $mailer->send('mail.monthaly_attendance', ['data' => $data], function ($message) use ($email,$subject) {

            $message->from('info@kathakbeats.in', 'Kathak Beats');

            $message->subject($subject);

            $message->to($email);

        });
    }
}
