<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Workshop;
use App\Models\WorkshopStudents;


class InvoiceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoice Generator';

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
        $quaterList = array(1,4,7,10);

        $getWorkshop = Workshop::where('is_completed',0)
                               ->where('is_active',1)
                               ->where('is_delete',0)
                               //->where('id','!=',5)
                               ->with(['workshopstudent' => function($q) { $q->with(['users']); }])
                               ->get();
        
        //loop with workshop        
        if(!is_null($getWorkshop)){
            foreach($getWorkshop as $wk => $wv){

                if($wv->engagement_type == 1 && $wv->engagement_mode == 2 || $wv->engagement_type == 2 && $wv->engagement_mode == 1 || $wv->engagement_type == 2 && $wv->engagement_mode == 2){
                    echo $wv->id;

                    //if workshop has student
                    if(!is_null($wv->workshopstudent)){
                        foreach($wv->workshopstudent as $sk => $sv){
                            if($sv->batch_status == 'CONTINUE'){
                                //if user object is not null in group
                                if(!is_null($sv->users)){
                                   
                                    //check current month
                                    $currentMonth = date('m');

                                    //create $data object
                                    $data['user_id'] = $sv->users->id;
                                    $data['workshop_id'] = $wv->id;
                                    $data['discount'] = 0;
                                    $data['medium'] = 0;
                                    $data['mode'] = 2;
                                    $data['payment_method'] = 2;
                                    $data['payment_remarks'] = '';

                                    
                                    //get last invoice form user
                                    $userGetLastInvoice = Invoice::where('user_id',$sv->users->id)->orderBy('id','desc')->first();

                                    //check last payment cycle of invoice
                                    if(!is_null($userGetLastInvoice) && $userGetLastInvoice->payment_cycle == 'QUARTERLY'){
                                        //check this month is fall into new quater or not if yes then add new quater
                                        if(in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'QUARTERLY'){
                                            $data['duration'] = 3;
                                            $data['cycle'] = 'QUARTERLY';
                                            $data['price'] = $this->countBatchPrice($wv->price,3,$sv->users->state_code);
                                        }

                                        //check this month is fall into new quater or not if yes then start payment from this month as monthly
                                        if(in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'MONTHLY'){
                                            $data['duration'] = 1;
                                            $data['cycle'] = 'MONTHLY';
                                            $data['price'] = $this->countBatchPrice($wv->price,1,$sv->users->state_code);
                                        }
                                    } else {

                                        //monthly
                                        if(in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'QUARTERLY'){
                                            $data['duration'] = 3;
                                            $data['cycle'] = 'QUARTERLY';
                                            $data['price'] = $this->countBatchPrice($wv->price,3,$sv->users->state_code);
                                        } else {
                                            if(!in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'QUARTERLY'){
                                                $data['duration'] = 1;
                                                $data['cycle'] = 'MONTHLY';
                                                $data['price'] = $this->countBatchPrice($wv->price,1,$sv->users->state_code);
                                            }                                    
                                        }

                                        if($sv->invoice_cycle == 'MONTHLY'){
                                            $data['duration'] = 1;
                                            $data['cycle'] = 'MONTHLY';
                                            $data['price'] = $this->countBatchPrice($wv->price,1,$sv->users->state_code);
                                        }
                                    }

                                    if(isset($data['duration'])){
                                        if($wv->engagement_type == 1 && $wv->engagement_mode == 2){
                                            $this->addPaymentEntry($data,$wv);
                                        } else if($wv->engagement_type == 2 && $wv->engagement_mode == 1){
                                            $this->addPaymentEntry($data,$wv);
                                        } else if($wv->engagement_type == 2 && $wv->engagement_mode == 2){
                                            $this->addPaymentEntry($data,$wv);
                                        }
                                    }

                                    if(!is_null($wv->users) && $wv->users->contact_number != ''){
                                        $message = 'Dear Student, this is a gentle reminder from KathakBeats to clear the fees due towards the month of '.date('M').', '.date('Y').' kindly do the needful at the earliest.';

                                        //$this->sendSmsNotification($wv->users->contact_number,$message);
                                    }
                                }
                            }
                        }
                    }
                } 
            }
        }          

        return 'true';
    }

    public function countBatchPrice($price, $duration, $state_code){

        $sgst_per = 9;
        $sgst_amount = 0;
        $cgst_per = 9;
        $cgst_amount = 0;
        $igst_per = 18;
        $igst_amount = 0;
        $totalPrice = 0;

        $updatePrice =  $price * $duration; // 5000 

        $totalGst = 100 + 18;
        $basePrice = (100 * $updatePrice) / $totalGst; 

        if($state_code != 22 && $state_code != ''){
            $sgst_amount = ($updatePrice - $basePrice) / 2;
            $cgst_amount = ($updatePrice - $basePrice) / 2;
        } else {
            $igst_amount = $updatePrice - $basePrice;
        }
               
        $round = 0;
        
        $data['sgst_per'] = $sgst_per;
        $data['cgst_per'] = $cgst_per;
        $data['igst_per'] = $igst_per;
        $data['sgst_amount'] = $sgst_amount;
        $data['cgst_amount'] = $cgst_amount;
        $data['igst_amount'] = $igst_amount;
        $data['basePrice'] = $basePrice;
        $data['roundValue'] = 0;
        $data['total_price'] = $updatePrice;

        return $data;
    }

    public function addPaymentEntry($data,$title){

        $number = $this->generateInvoiceNumber();

        $invoice = new Invoice;
        $invoice->invoice_number = $number['invoice_number'];
        $invoice->order_number = $number['order_number'];
        $invoice->number = $number['number'];
        $invoice->workshop_id = $data['workshop_id'];
        $invoice->user_id = $data['user_id'];
        $invoice->kb_state = 'Maharashtra';
        $invoice->payment_cycle = $data['cycle'];
        $invoice->discount = $data['discount'];
        $invoice->invoice_date = null;
        $invoice->medium = $data['medium'];
        $invoice->mode = $data['mode'];
        $invoice->payment_method = 2;
        $invoice->payment_remarks = '';
        $invoice->amount_words = $this->getIndianCurrency($data['price']['total_price']);
        $invoice->round_off = $data['price']['roundValue'];
        $invoice->amount = $data['price']['total_price'];
        $invoice->base_price = $data['price']['basePrice'];
        $invoice->sgst_per = $data['price']['sgst_per'];
        $invoice->cgst_per = $data['price']['cgst_per'];
        $invoice->igst_per = $data['price']['igst_per'];
        $invoice->sgst_amount = $data['price']['sgst_amount'];
        $invoice->cgst_amount = $data['price']['cgst_amount'];
        $invoice->igst_amount = $data['price']['igst_amount'];
        $invoice->status = 'PENDING';
        $invoice->save();

        $iDetail = new InvoiceDetail;
        $iDetail->invoice_id = $invoice->id;
        $iDetail->perticulars = $title;
        $iDetail->qty = 1;
        $iDetail->fees = $data['price']['total_price'];
        $iDetail->save();

        $data['invoice_id'] = $invoice->id;

        $logData = $data['user_id']."----".$invoice->id;

        \Log::info('--------------------------------------------------------------------');
        \Log::info('Invoice Status :'.$logData);
        \Log::info('--------------------------------------------------------------------');

        return $data;
    }

    public function generateInvoiceNumber(){

        $getInvoice = Invoice::where('payment_method',2)->orderBy('id','desc')->first();

        if(!is_null($getInvoice)){
            $data['invoice_number'] = "KB/ONL/".$this->financialYear()."/".($getInvoice->number + 1);
            $data['order_number'] = "KB ".$this->financialYear()."/".($getInvoice->number + 1);
            $data['number'] = $getInvoice->number + 1;
        } else {
            $data['invoice_number'] = "KB/ONL/".$this->financialYear()."/1";
            $data['order_number'] = "KB ".$this->financialYear()."/1";
            $data['number'] = 1;
        }

        return $data;
    }

    public function financialYear(){

        $year = date('Y');
        $month = date('m');
        if($month<4){
            $year = $year - 1;
        }
        return substr($year, 2).'-'.substr(($year + 1),2);
    }

    public function getIndianCurrency(float $number){
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

}
