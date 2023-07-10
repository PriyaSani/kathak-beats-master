<?php

namespace App\Console\Commands;

use App\Jobs\Reminder;
use Illuminate\Console\Command;
use App\Models\Workshop;
use App\Models\WorkshopAttendance;
use Illuminate\Foundation\Bus\DispatchesJobs;

class sendReminder extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to user before 2 hours';

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
                $currentDate = date('Y-m-d');
                $currentTime = date('H:i',strtotime('+2 hours'));
                $getData = WorkshopAttendance::where('workshop_id',$wv->id)->whereDate('date',$currentDate)->where('start_time',$currentTime)->first();
                if(!is_null($getData) && !is_null($wv->workshopstudent)){
                    foreach($wv->workshopstudent as $uk => $uv){
                        if(!is_null($uv->users)){
                            if($uv->users->email != ''){
                                $this->dispatch((new Reminder($uv->users->email,$wv->title))->delay(5));
                            }

                            if($uv->users->contact_number != ''){
                                $facultName = !is_null($wv->workshopfaculty) ? $wv->workshopfaculty[0]->faculty->name : '';
                                $message = 'Dear Student, here is a reminder about your class – '.$wv->title.' – conducted by – '.$facultName.' - which begins in next 2 hours, Team KathakBeats.';
                                $this->sendReminderNotification($uv->users->contact_number,$message);
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

    public function sendReminderNotification($mobile,$message){

        $url = 'http://bhashsms.com/api/sendmsg.php?user=Kathakedu&pass=123456&phone='.$mobile.'&sender=KATHKB&text='.urlencode($message).'&priority=ndnd&stype=normal';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        return 'true';
    }
}
