<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalController extends Controller
{
    
    public function generateUUID(){
        return (string) Str::uuid();
    }

    // public function uploadBucket($image,$path){
    //     $imagedata = $image;
    //     $extension = $imagedata->getClientOriginalExtension(); 
    //     $fileName = rand(11111,99999).'.'.$extension;
    //     $destinationPath = "uploads/".$path."/".$fileName;
    //     $s3 = \Storage::disk('s3');
    //     $s3->put($destinationPath, file_get_contents($imagedata), 'public-read');
    //     return $fileName;
    // }

    public function uploadBucket($image,$path){

        $imagedata = $image;
        $extension = $imagedata->getClientOriginalExtension(); 
        $fileName = rand(11111,99999).'.'.$extension;
        $destinationPath = "/uploads/".$path."/".$fileName;
        $s3 = \Storage::disk('s3');
        $s3->put($destinationPath, file_get_contents($imagedata));
        return $fileName;
    }
    
    public function uploadImage($image,$path,$uuid = null){

        $imagedata = $image;
        $destinationPath = $uuid != '' ? 'uploads/'.$path."/".$uuid : 'uploads/'.$path;
        $extension = $imagedata->getClientOriginalExtension(); 
        $fileName = rand(11111,99999).'.'.$extension;
        $imagedata->move($destinationPath, $fileName);
        
        return $fileName;
    }

    public function checkCity($name){

        $city = City::where('name',$name)->first();
        
        if(is_null($city)){
            $city = new City;
            $city->name = $name;
            $city->save();
        }

        return $city->id;
    }

    public function checkCountry($name){

        $country = Country::where('name',$name)->first();
        
        if(is_null($country)){
            $country = new Country;
            $country->name = $name;
            $country->save();
        }

        return $country->id;
    }

    public function checkState($name){

        $state = State::where('name',$name)->first();

        if(is_null($state)){
            $state = new State;
            $state->name = $name;
            $state->save();
        }

        return $state->id;
    }

    public function getCity(){

        $city = City::all();

        $cityJson = array();

        if(!is_null($city)){
            foreach($city as $ck => $cv){
                $cityJson[$ck]['label'] = $cv->name;
                $cityJson[$ck]['value'] = $cv->id;
            }
        }
        return $cityJson;    
    }

    public function getState(){

        $state = State::all();

        $stateJson = array();

        if(!is_null($state)){
            foreach($state as $sk => $sv){
                $stateJson[$sk]['label'] = $sv->name;
                $stateJson[$sk]['value'] = $sv->id;
            }
        }
        
        return $stateJson;    
    }

    public function getCountry(){

        $country = Country::all();

        $countryJson = array();

        if(!is_null($country)){
            foreach($country as $sk => $sv){
                $countryJson[$sk]['label'] = $sv->name;
                $countryJson[$sk]['value'] = $sv->id;
            }
        }
        
        return $countryJson;    
    }

    public function convertDate($date){

        $date = explode('/',$date);

        return trim($date[2])."-".trim($date[1]).'-'.trim($date[0]);
    }

    public function convertDateUs($date){

        $date = explode('/',$date);

        return trim($date[2])."-".trim($date[0]).'-'.trim($date[1]);
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

    public function countBatchPrice($price, $duration, $state_code = 27){

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

        
        $sgst_amount = ($updatePrice - $basePrice) / 2;
        $cgst_amount = ($updatePrice - $basePrice) / 2;
        $igst_amount = $sgst_amount + $cgst_amount;   

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

    public function addPaymentEntry($data,$workshop = null){

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
        $iDetail->perticulars = $workshop->title;
        $iDetail->qty = 1;
        $iDetail->fees = $data['price']['total_price'];
        $iDetail->save();

        $data['invoice_id'] = $invoice->id;

        return $data;
    }

    public function getfinancialYear(){

        $year = date('Y');
        $month = date('m');
        if($month<4){
            $year = $year - 1;
        }
        return substr($year, 2).'-'.substr(($year + 1),2);
    }

    public function generateInvoiceNumber(){

        $getInvoice = Invoice::where('medium',2)->orderBy('id','desc')->first();

        if(!is_null($getInvoice)){
            $data['invoice_number'] = "KB/ONL/".$this->getfinancialYear()."/".($getInvoice->number + 1);
            $data['order_number'] = "KB ".$this->getfinancialYear()."/".($getInvoice->number + 1);
            $data['number'] = $getInvoice->number + 1;
        } else {
            $data['invoice_number'] = "KB/ONL/".$this->getfinancialYear()."/1";
            $data['order_number'] = "KB ".$this->getfinancialYear()."/1";
            $data['number'] = 1;
        }

        return $data;
    }

    public function sendSmsNotification($mobile,$message){

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
