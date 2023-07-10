<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GstReports;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GstController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function generateInvoiceExcel(Request $request){

        $query = Invoice::where('is_active',1)->where('is_delete',0);

        if(isset($request->daterange) && $request->daterange != ''){
            $startDateRange = $request->daterange;
            $date = explode('-',$request->daterange);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereBetween('created_at',[$date1,$date2]);
        }

        $query->with(['user','workshop']);
        $invoice = $query->get();

        $current_date_time = date("dmyhis");

        $data = array();
        $heading = array('Sr.No','Invoice No','Student Name','Batch Name','Base Price','GST','CGST','SGST','IGST','Total');

        $i = 1;
        if(!is_null($invoice)){
            foreach($invoice as $ik => $iv){
                $data[$ik]['sr_no'] = $i;
                $data[$ik]['invoice_number'] = $iv->invoice_date != '' ? $iv->invoice_number : '----';
                $data[$ik]['student_name'] = $iv->user->name;
                $data[$ik]['batch_name'] = $iv->workshop->title;
                $data[$ik]['base_price'] = number_format($iv->base_price,2);
                $data[$ik]['gst'] = "18%";
                if($iv->user->state_code == 27){
                    $data[$ik]['cgst'] = number_format($iv->cgst_amount,2);
                    $data[$ik]['sgst'] = number_format($iv->sgst_amount,2);
                    $data[$ik]['igst'] = "";
                } else {
                    $data[$ik]['cgst'] = "";
                    $data[$ik]['sgst'] = "";
                    $data[$ik]['igst'] = $iv->igst_amount != '' ? number_format($iv->igst_amount,2) : number_format($iv->cgst_amount + $iv->sgst_amount,2);
                }

                $data[$ik]['total'] = $iv->amount;
                $i++;
            }
        }

        return Excel::download(new GstReports($data,$heading), 'gst_excel_'.$current_date_time.'.xlsx');
    }
}
