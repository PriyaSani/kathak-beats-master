<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Invoice</title>
        <style>
            .page-break {
                page-break-after: always;
                page-break-inside: auto;
            }
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
                    <b> Invoice No : {{ $data['invoice_number'] }} </b> 
                </td>

                <td colspan="4" style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b>Order No : {{ $data['order_number'] }}</b> 
                </td>

                <td colspan="4" style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b> Invoice Date: {{ $data['invoice_date'] }} </b>    
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>State : {{ $data['kb_state'] }} </b> 
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b> Transaction ID : TXNKB0001</b> 
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
                    <b>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $data['name'] }}</b>
                </td>
            </tr>

            <tr style="border-top: 1px solid black;  border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;{{ $data['address'] }}</b>
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Phone No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $data['phone_number'] }}</b>
                </td>
            </tr>

            <tr style="border-top: 1px solid black; border-spacing: 0;">
                <td colspan="12" style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $data['state'] }}</b> 
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
                @if($user->state_code == 27)
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        <b>CGST (Rs.)</b>    
                    </td>
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        <b>SGST (Rs.)</b>    
                    </td>
                @else
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                        <b>IGST (Rs.)</b>    
                    </td>
                @endif
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Total (Rs.)</b>    
                </td>

            </tr>
            @php 
                $total = 0; 
                $g = 0;
            @endphp
            @if(!is_null($data['data']))
                @foreach($data['data'] as $dk => $dv)
                    <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            {{ $loop->iteration }}
                        </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            {{ $dv['title'] }}
                        </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            {{ $dv['qty'] }}
                        </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            @php 
                                $totalGst = 100 + 18;
                                $basePrice = (100 * $dv['fees']) / $totalGst;
                                $gst = $dv['fees'] - $basePrice;
                                $g += $gst;
                                $cgst = $gst / 2;
                                $sgst = $gst / 2;
                            @endphp

                            {{ number_format($basePrice,2) }}    
                        </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            0
                        </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            999291
                        </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            18%
                        </td>
                        @if($user->state_code == 27)
                            <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                                {{ number_format($cgst,2) }}
                            </td>
                            <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                                {{ number_format($sgst,2) }}
                            </td>
                        @else
                            <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                                @php $sum = $cgst + $sgst; @endphp
                                {{ number_format($sum,2) }}
                            </td>
                        @endif
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                            {{ number_format($dv['total'],2) }}
                            @php $total += $dv['total']; @endphp
                        </td>

                    </tr>
                @endforeach
            @endif

             <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td colspan="6" style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align:center;background-color: #ddd9c3;">
                    <b>TOTAL (Rs.)</b>
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black"></td>
                @if($user->state_code == 27)
                    <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black"></td>
                @endif
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black"></td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    {{ number_format($total,2) }}
                </td>
            </tr>


           
            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">
                <td @if($user->state_code == 27) colspan="8" @else colspan="7" @endif style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    @php $mode = array('1' => 'Cash','2' => 'Online/UPI','3' => 'Cheque'); @endphp
                    <b>Payment Mode : {{ array_key_exists($data['payment_method'],$mode) ? $mode[$data['payment_method']]  : 'Cash' }}</b>
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <b>Total Amount (Rs.)</b>
                </td>
                <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black">
                    <!-- {{ $data['total_amount'] }} -->
                    {{ number_format($total,2) }}
                </td>
            </tr>

            

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;height:20px!important;">
                <td @if($user->state_code == 27) colspan="10" @else colspan="9" @endif style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b>Terms & Conditions :  </b><br /><br />
                    - No refunds<br/>
                    - Confirmation to attendees are non-transferrable (Registered email id will ONLY get access to the workshop/regular class)<br />
                    - Under any situation, once payment is confirmed for an workshop/batch, it CANNOT be exchanged with any other workshop/batch
                </td>
            </tr>

            

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;height:20px!important;">
                <td @if($user->state_code == 27) colspan="8"  rowspan="6" @else colspan="7"  rowspan="6" @endif style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                    <b>Total Invoice Amount in Words : <br>{{ ucwords($data['total_in_words']) }} </b><br/><br/><br/>
                </td>
                <td colspan="2"  style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">

                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>Total Amount </b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ number_format($total - $gst,2) }}</td>
                    </tr>

                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>GST ( Rs.)</b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ number_format($gst,2) }}</td>
                    </tr>

                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>Discount ( Rs.)</b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ $data['discount'] }}</td>
                    </tr>
                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>Round Off (Rs.)</b></td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">0</td>
                    </tr>
                    <tr style="border: 2px solid black;font-size: 12px;padding:4px;color: black;">
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;"><b>TOTAL ( Rs.) </b> </td>
                        <td style="border: 2px solid black;font-size: 12px;padding:4px;color: black;text-align: center;">{{ $data['total_amount'] }}</td>
                    </tr>
                </td>
            </tr>

            
            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">

                <td @if($user->state_code == 27) colspan="10" @else colspan="9" @endif style="border: 2px solid black;font-size: 36px;padding-bottom: 2%;color: black;width: 5%!important;">
                    <center>
                        <b style="border:1px solid black;">    
                            PAID
                        </b> 
                    </center>
                </td>

            </tr>

            <tr style="border-top: 1px solid black; border-collapse: collapse; border-spacing: 0;">

                <td @if($user->state_code == 27) colspan="10" @else colspan="9" @endif style="border: 2px solid black;font-size: 16px;padding-bottom: 2%;color: black;width: 5%!important;">
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