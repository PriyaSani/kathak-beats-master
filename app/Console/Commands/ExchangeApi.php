<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExchangeData;

class ExchangeApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:exchange-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Exchange Rate';

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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apilayer.com/exchangerates_data/latest?base=USD&symbols=EUR,GBP,INR',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: eIU7f0rH5OjnY1j8ZJvfonGK2IT39Pv3'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response,true);

        $update = ExchangeData::where('key','USD')->update(['price' => $data['rates']['INR']]);

        \Log::info('---------------------------------------------------------------------');
        \Log::info('-------------------Exchange Rates Updated successfully---------------');
        \Log::info('---------------------------------------------------------------------');

    }
}
