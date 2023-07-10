<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Workshop;

class checkWorkshopStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Workshop complete status change';

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
        $getWorkshopList = Workshop::where([['is_completed',0],['is_active',1],['is_delete',0]])->whereDate('end_date','<',date('Y-m-d'))->update(['is_completed' => 1]);

        \Log::info('-----------------------------------------------');
        \Log::info('Workshop list updated');
        \Log::info('-----------------------------------------------');
    }
}
