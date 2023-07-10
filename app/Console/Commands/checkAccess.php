<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Workshop;
use App\Models\WorkshopStudent;

class checkAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User access for workshop';

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
        $workshop = Workshop::where('engagement_type',2)->where('is_active',1)->where('is_delete',0)->pluck('id')->toArray();
        $studio = Workshop::where('engagement_type',1)->where('engagement_mode',2)->where('is_active',1)->where('is_delete',0)->pluck('id')->toArray();

        $id = array_unique(array_merge($workshop,$studio));


        $invoiceList = Invoice::whereIn('workshop_id',$id)->where('status', 'PENDING')->with(['user'])->get();

        \Log::info('-----------------------------------------------');
        \Log::info('User access for workshop');

        if (!is_null($invoiceList)) {
            foreach ($invoiceList as $ik => $iv) {
                $updateWorkshop = WorkshopStudent::where('workshop_id',$iv->workshop_id)->where('student_id',$iv->user_id)->update(['is_active' => 1]);
                //$userUpdate = User::where('id', $iv->user->id)->update(['is_active' => 0]);
                \Log::info('User access for workshop'.$iv->user->id.' -- workshop_id --'.$iv->workshop_id);
            }
        }
        \Log::info('-----------------------------------------------');
    }
}
