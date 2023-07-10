<?php

namespace App\Console\Commands;

use App\Jobs\MonthlyAttendance;
use Illuminate\Console\Command;
use App\Models\Workshop;
use App\Models\WorkshopAttendance;
use App\Models\WorkshopAttendanceDetail;
use Illuminate\Foundation\Bus\DispatchesJobs;


class monthlyAttandance extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:monthlyattandance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Monthly attandance report to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $getWorkshopList = Workshop::where([['is_completed',0],['is_active',1],['is_delete',0]])->with(['workshopfaculty' => function($q) { $q->with(['faculty']);},'workshopstudent' => function($q) { $q->with(['users']); }])->get();

        if(!is_null($getWorkshopList)){
            foreach($getWorkshopList as $wk => $wv){
                
                $a_date = date('Y-m-d');
                $lastMonth = date('m',strtotime('-1 month'));
                $monthName = date('M',strtotime('-1 month'));
                $from = date("Y-m-01", strtotime($a_date."-1 month"));
                $to = date("Y-m-t", strtotime($a_date."-1 month"));

                $getData = WorkshopAttendance::where('workshop_id',$wv->id)->whereBetween('date',[$from, $to])->pluck('id')->toArray();

                if(!is_null($getData) && !is_null($wv->workshopstudent)){
                    foreach($wv->workshopstudent as $uk => $uv){
                        if(!is_null($uv->users)){
                            if($uv->users->email != ''){
                                $total = count($getData);
                                $getStudent = WorkshopAttendanceDetail::whereIn('workshop_attendance_id',$getData)->where('student_id',$uv->users->id)->count();
                                $this->dispatch((new MonthlyAttendance($uv->users->email,$total,$getStudent,$monthName,$wv->title))->delay(5));
                            }
                        }
                    }
                }
            }
        }

        \Log::info('-----------------------------------------------');
        \Log::info('Workshop and Batch Reminer Done');
        \Log::info('-----------------------------------------------');
    }
}
