<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Invoice | KathakBeats</title>
        <link rel="shortcut icon" href="http://localhost:8000/front/images/favicon.ico" />
        <style>
            .page-break {page-break-after: always;page-break-inside: auto;}
        </style>
    </head>
    <body style="position: relative; margin: 0 auto; color: #555555; background: #FFFFFF; font-family: Arial, sans-serif; font-size: 12px; font-family: SourceSansPro;order: 4px solid black;">
        
        <div>
            <h2 style="text-align: left !important;">
                Payment Invoice
            </h2>
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left!important"><b>CIN : AAO-1660</b></td>
                    <td style="text-align: right!important"><b>PAN No : AAVFK8417E</b></td>
                </tr>
            </table>
        </div>

        <div>
            <center>
                <h3>
                    Kathak Beats <br>
                    Kathak Beats Edutainment LLP <br>
                    <a href="www.kathakbeats.in" target="_blank"> www.kathakbeats.in </a>
                </h3>
            </center>
        </div>

        <table align="center" style="border: 2px solid black; border-collapse: collapse;width: 100%;">
            
            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="4" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b> Invoice No : {{ $getInvoiceDetail->invoice_number }} </b> 
                </td>

                <td colspan="4" style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b>Order No : {{ $getInvoiceDetail->order_number }}</b> 
                </td>

                <td colspan="4" style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b> Invoice Date: {{ date('d/m/Y') }} </b>    
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>State : {{ $getInvoiceDetail->kb_state }} </b> 
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b> Transaction ID : {{ $getInvoiceDetail->transaction_id }}</b> 
                </td>
            </tr>
        </table>

        <table align="center" style="border: 2px solid black; border-collapse: collapse; margin-top: 20px !important;width: 100%">
            <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;background-color: #ddd9c3;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b> STUDENT DETAILS</b> 
                </td>
            </tr>

            <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $getInvoiceDetail->user->name }}</b>
                </td>
            </tr>

            <tr style="border-top: 1px solid black;  border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;{{ $getInvoiceDetail->user->address }}</b>
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Phone No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $getInvoiceDetail->user->contact_number }}</b>
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ !is_null($getInvoiceDetail->user) && !is_null($getInvoiceDetail->user->state) ? $getInvoiceDetail->user->state->name : "" }}</b> 
                </td>
            </tr>
        </table>

        <table align="center" style="border: 2px solid black; border-collapse: collapse; margin-top: 20px !important;width: 100%">
            <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;background-color: #ddd9c3;">
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Sr. No</b> 
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Particulars</b> 
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Qty</b>    
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Fees (Rs.)</b>    
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Discount </b>    
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>HSN </b>    
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>GST(%) </b>    
                </td>
                @if($getUserInfo->state_code == 27)
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        <b>CGST (Rs.)</b>    
                    </td>
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        <b>SGST (Rs.) </b>    
                    </td>
                @else
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        <b>IGST (Rs.) </b>    
                    </td>
                @endif
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Total (Rs.)</b>    
                </td>

            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    1
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ $getInvoiceDetail->workshop->title }}
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ $getInvoiceDetail->payment_cycle == 'MONTHLY' ? 1 : 3 }}
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ number_format($getInvoiceDetail->base_price,2) }}
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ number_format($getInvoiceDetail->discount,2) }}
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    999291
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    18%
                </td>
                @if($getUserInfo->state_code == 27)
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        {{ number_format($getInvoiceDetail->sgst_amount,2) }}
                    </td>
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        {{ number_format($getInvoiceDetail->cgst_amount,2) }}
                    </td>
                @else 
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        {{ number_format($getInvoiceDetail->igst_amount,2) }}
                    </td>
                @endif
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ number_format($getInvoiceDetail->amount,2) }}
                </td>

            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="6" style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align:center;background-color: #ddd9c3;">
                    <b>TOTAL (Rs.)</b>
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black"></td>
                @if($getUserInfo->state_code == 27)
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black"></td>
                @endif
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black"></td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ number_format($getInvoiceDetail->amount,2) }}
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td @if($getUserInfo->state_code == 27) colspan="8" @else colspan="7" @endif style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    @php $mode = array('1' => 'Cash','2' => 'Online/UPI','3' => 'Cheque'); @endphp
                    <b>Payment Mode : {{ $mode[$getInvoiceDetail->payment_method] }}</b>
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Total Amount (Rs.)</b>
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ number_format($getInvoiceDetail->amount,2) }}
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;height:20px!important;">
                <td @if($getUserInfo->state_code == 27) colspan="10" @else colspan="9" @endif    style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b>Terms & Conditions : </b><br /><br />
                    - No refunds<br/>
                    - Confirmation to attendees are non-transferrable (Registered email id will ONLY get access to the workshop/regular class)<br />
                    - Under any situation, once payment is confirmed for an workshop/batch, it CANNOT be exchanged with any other workshop/batch
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;height:20px!important;">
                <td @if($getUserInfo->state_code == 27) colspan="8"  rowspan="6" @else colspan="7"  rowspan="6" @endif style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b>Total Invoice Amount in Words : <br>{{ ucwords($getInvoiceDetail->amount_words) }} </b><br/><br/><br/>
                </td>
                <td colspan="2"  style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    @php $gst = $getInvoiceDetail->sgst_amount + $getInvoiceDetail->cgst_amount + $getInvoiceDetail->igst_amount @endphp
                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>Total Amount </b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ number_format($getInvoiceDetail->amount - $gst,2) }}</td>
                    </tr>

                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>GST ( Rs.)</b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ number_format($gst,2) }}</td>
                    </tr>

                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>Discount ( Rs.)</b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">0</td>
                    </tr>
                                      
                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>Round Off ( Rs.)</b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ number_format($getInvoiceDetail->round_off,2) }}</td>
                    </tr>
                    
                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>TOTAL ( Rs.) </b> </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ number_format($getInvoiceDetail->amount,2) }}</td>
                    </tr>
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td @if($getUserInfo->state_code == 27) colspan="10" @else colspan="9" @endif style="border: 2px solid black;font-size: 36px;padding-bottom: 2%;color: black;width: 5%!important;">
                    <center>
                        <b style="border:1px solid black;">    
                            PAID
                        </b> 
                    </center>
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td @if($getUserInfo->state_code == 27) colspan="10" @else colspan="9" @endif style="border: 2px solid black;font-size: 16px;padding-bottom: 2%;color: black;width: 5%!important;">
                    <center>
                        <b>    
                            For Kathak Beats Edutainment LLP <br><br>
                        </b> 

                        This is computer generated invoice and does not require a signature
                    </center>
                </td>
            </tr>
        </table>

    </body>
</html>